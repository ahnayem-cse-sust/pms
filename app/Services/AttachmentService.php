<?php

namespace App\Services;

use App\Models\SystemSetting;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AttachmentService
{
    /** Extensions that are never accepted, even if an admin adds them to the whitelist. */
    protected array $blocked = ['php', 'phtml', 'exe', 'bat', 'cmd', 'com', 'js', 'vbs', 'ps1', 'sh', 'msi', 'dll', 'jar', 'html', 'htm', 'svg'];

    public function store(Ticket $ticket, User $user, UploadedFile $file, bool $internal = false, ?int $commentId = null): TicketAttachment
    {
        $allowed = array_filter(array_map('trim', explode(',', strtolower(
            SystemSetting::get('upload.allowed_ext', 'jpg,jpeg,png,pdf,doc,docx,xls,xlsx,txt,log,zip')
        ))));
        $maxKb = (int) SystemSetting::get('upload.max_kb', 10240);
        $ext = strtolower($file->getClientOriginalExtension());

        if (! $file->isValid()) {
            $this->fail('Upload failed for ' . $file->getClientOriginalName() . '.');
        }
        if (in_array($ext, $this->blocked, true) || ! in_array($ext, $allowed, true)) {
            $this->fail("File type .{$ext} is not allowed.");
        }
        if (($file->getSize() / 1024) > $maxKb) {
            $this->fail($file->getClientOriginalName() . " exceeds the {$maxKb} KB limit.");
        }

        $size = $file->getSize();
        $mime = $file->getMimeType() ?: 'application/octet-stream';
        $hash = hash_file('sha256', $file->getRealPath());
        $stored = $file->storeAs('ticket-attachments/' . $ticket->id, Str::random(40) . '.' . $ext, 'local');

        return TicketAttachment::create([
            'ticket_id' => $ticket->id,
            'comment_id' => $commentId,
            'uploaded_by' => $user->id,
            'original_name' => $file->getClientOriginalName(),
            'stored_path' => $stored,
            'mime_type' => $mime,
            'extension' => $ext,
            'size_bytes' => $size,
            'sha256' => $hash,
            'is_internal' => $internal,
            'scan_status' => 'skipped', // hook: set to 'pending' and queue a ClamAV scan job
        ]);
    }

    protected function fail(string $msg): void
    {
        throw ValidationException::withMessages(['attachments' => $msg]);
    }
}
