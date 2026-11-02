<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\DepartmentFile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** File Management: list / search, add, edit and delete department files. Gated by file.* permissions (see routes/web.php). */
class FileController extends Controller
{
    public function index(Request $r)
    {
        return view('files.index', ['files' => $this->filtered($r)->paginate(25)->withQueryString(), 'sections' => $this->sections()]);
    }

    /** PDF of the file list, with the same search / section filter as the screen (all matching rows, not just one page). */
    public function pdf(Request $r)
    {
        $files = $this->filtered($r)->get();

        return Pdf::loadView('files.pdf', [
            'files' => $files, 'section' => $r->section, 'q' => $r->q,
            'generatedBy' => auth()->user()->name, 'generatedAt' => now(),
        ])->setPaper('a4', 'portrait')->download('Department-Files_'.now()->format('Y-m-d').'.pdf');
    }

    protected function filtered(Request $r)
    {
        return DepartmentFile::query()
            ->when($r->q, fn ($q, $s) => $q->where(fn ($w) => $w->where('file_no', 'like', "%$s%")
                ->orWhere('title', 'like', "%$s%")->orWhere('shelf_no', 'like', "%$s%")->orWhere('section', 'like', "%$s%")))
            ->when($r->section, fn ($q, $v) => $q->where('section', $v))
            ->orderBy('file_no');
    }

    public function create()
    {
        return view('files.form', ['file' => new DepartmentFile, 'sections' => $this->sections()]);
    }

    public function store(Request $r)
    {
        $file = DepartmentFile::create($this->validated($r));
        AuditLog::record('file.created', $file, null, $file->only(['file_no', 'title', 'shelf_no', 'section']));

        return redirect()->route('files.index')->with('ok', 'File added.');
    }

    public function edit(DepartmentFile $file)
    {
        return view('files.form', ['file' => $file, 'sections' => $this->sections()]);
    }

    public function update(Request $r, DepartmentFile $file)
    {
        $old = $file->only(['file_no', 'title', 'shelf_no', 'section']);
        $file->update($this->validated($r, $file));
        AuditLog::record('file.updated', $file, $old, $file->only(['file_no', 'title', 'shelf_no', 'section']));

        return redirect()->route('files.index')->with('ok', 'File updated.');
    }

    public function destroy(DepartmentFile $file)
    {
        AuditLog::record('file.deleted', $file, $file->only(['file_no', 'title', 'shelf_no', 'section']), null);
        $file->delete();

        return redirect()->route('files.index')->with('ok', 'File deleted.');
    }

    protected function validated(Request $r, ?DepartmentFile $file = null): array
    {
        $d = $r->validate([
            'file_no' => ['required', 'string', 'max:50', Rule::unique('department_files', 'file_no')->ignore($file?->id)],
            'title' => 'required|string|max:255',
            'shelf_no' => 'required|string|max:50',
            'section' => 'required|string|max:150',
        ], [
            'file_no.unique' => 'A file with this file number already exists.',
        ]);

        return array_map('trim', $d);
    }

    /** Sections already in use, for the filter and as suggestions on the form. */
    protected function sections()
    {
        return DepartmentFile::query()->distinct()->orderBy('section')->pluck('section');
    }
}
