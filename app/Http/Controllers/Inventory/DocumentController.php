<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\{Asset, Disposal, Document, Maintenance, Receipt, Adjustment};
use App\Services\AttachmentService;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/** Supporting files (invoice, warranty certificate, delivery note, handover form, repair document ...). Same type/size rules as ticket uploads. */
class DocumentController extends InvController
{
    /** owner type => [model, permission that may upload, permission that may download] */
    protected array $owners = [
        'asset' => [Asset::class, 'inv.asset.update', 'inv.asset.view'],
        'receipt' => [Receipt::class, 'inv.receipt.create', 'inv.receipt.view'],
        'maintenance' => [Maintenance::class, 'inv.maint.update', 'inv.maint.view'],
        'disposal' => [Disposal::class, 'inv.disposal.create', 'inv.disposal.view'],
        'adjustment' => [Adjustment::class, 'inv.adjust.create', 'inv.adjust.view'],
    ];

    public function store(Request $r, string $type, int $id)
    {
        abort_unless(isset($this->owners[$type]), 404);
        [$model, $up] = $this->owners[$type];
        $this->authorize($up);
        $model::findOrFail($id);
        $r->validate(['file' => 'required|file', 'doc_type' => 'nullable|string|max:30']);
        $f = $r->file('file');
        $allowed = array_filter(array_map('trim', explode(',', strtolower(SystemSetting::get('upload.allowed_ext', 'jpg,jpeg,png,pdf,doc,docx,xls,xlsx,txt,log,zip')))));
        $ext = strtolower($f->getClientOriginalExtension());
        $blocked = ['php', 'phtml', 'exe', 'bat', 'cmd', 'com', 'js', 'vbs', 'ps1', 'sh', 'msi', 'dll', 'jar', 'html', 'htm', 'svg'];
        if (! $f->isValid() || in_array($ext, $blocked, true) || ! in_array($ext, $allowed, true)) {
            throw ValidationException::withMessages(['file' => "File type .{$ext} is not allowed."]);
        }
        if ($f->getSize() / 1024 > AttachmentService::maxKb()) {
            throw ValidationException::withMessages(['file' => 'The file is larger than the upload limit.']);
        }
        $doc = Document::create([
            'owner_type' => $type, 'owner_id' => $id, 'original_name' => $f->getClientOriginalName(), 'mime_type' => $f->getMimeType(), 'size_bytes' => $f->getSize(),
            'stored_path' => $f->storeAs("inventory-docs/$type/$id", Str::random(40).'.'.$ext, 'local'), 'doc_type' => $r->doc_type, 'uploaded_by' => auth()->id(),
        ]);
        $this->audit('document.uploaded', $doc, null, ['owner' => "$type#$id", 'name' => $doc->original_name]);

        return back()->with('ok', 'Document attached.');
    }

    public function download(Document $document)
    {
        [$model, , $view] = $this->owners[$document->owner_type];
        $u = auth()->user();
        $owner = $model::findOrFail($document->owner_id);
        abort_unless($owner instanceof Asset ? $owner->canBeSeenBy($u) : $u->hasPermission($view), 403);
        abort_unless(Storage::disk('local')->exists($document->stored_path), 404);

        return Storage::disk('local')->download($document->stored_path, $document->original_name);
    }
}
