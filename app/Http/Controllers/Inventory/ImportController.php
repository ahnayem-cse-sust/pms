<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Inventory\ImportBatch;
use App\Services\Inventory\ImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImportController extends InvController
{
    public function __construct(protected ImportService $imp) {}

    public function index()
    {
        return view('inventory.import.index', ['batches' => ImportBatch::with('uploader')->latest('id')->paginate(15), 'kinds' => ['ASSETS' => 'Asset register', 'OPENING_STOCK' => 'Opening stock']]);
    }

    public function template(string $kind)
    {
        abort_unless(isset(ImportService::COLS[$kind]), 404);

        return response()->streamDownload(function () use ($kind) {
            $o = fopen('php://output', 'w');
            fputcsv($o, ImportService::COLS[$kind]);
            fputcsv($o, ImportService::SAMPLE[$kind]);
            fclose($o);
        }, strtolower($kind).'_import_template.csv', ['Content-Type' => 'text/csv']);
    }

    public function upload(Request $r)
    {
        $d = $r->validate(['kind' => 'required|in:ASSETS,OPENING_STOCK', 'file' => 'required|file|mimes:csv,txt|max:4096', 'source_ref' => 'required|string|max:255']);
        $f = $r->file('file');
        $path = $f->storeAs('inventory-imports', Str::random(30).'.csv', 'local');
        [$rows, $errors] = $this->imp->validate($d['kind'], \Illuminate\Support\Facades\Storage::disk('local')->path($path));
        $b = ImportBatch::create(['ref' => $this->svc()->ref('import'), 'kind' => $d['kind'], 'file_name' => $f->getClientOriginalName(), 'stored_path' => $path, 'source_ref' => $d['source_ref'],
            'total_rows' => count($rows), 'error_rows' => count(array_unique(array_column($errors, 'line'))), 'status' => 'PREVIEW', 'uploaded_by' => auth()->id()]);
        $this->audit('import.uploaded', $b, null, ['ref' => $b->ref, 'file' => $b->file_name]);

        return redirect()->route('inv.import.show', $b);
    }

    public function show(ImportBatch $batch)
    {
        $path = \Illuminate\Support\Facades\Storage::disk('local')->path($batch->stored_path);
        [$rows, $errors] = $batch->status === 'PREVIEW' ? $this->imp->validate($batch->kind, $path) : [[], []];
        [$head, $raw] = is_file($path) ? $this->imp->parse($path) : [[], []];

        return view('inventory.import.show', ['b' => $batch, 'rowErrors' => $errors, 'head' => $head, 'preview' => array_slice($raw, 0, 200), 'total' => count($raw)]);
    }

    public function post(Request $r, ImportBatch $batch)
    {
        abort_unless($batch->status === 'PREVIEW', 422);
        $r->validate(['verified' => 'accepted']);
        $this->imp->post($batch);

        return redirect()->route('inv.import.show', $batch)->with('ok', 'Imported and posted.');
    }
}
