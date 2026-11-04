<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Department Files</title>
<style>
    @page { margin: 28px 30px 40px; }
    body { font-family: {{ $mpdf ? 'kalpurush' : 'DejaVu Sans, sans-serif' }}; font-size: 10px; color: #1c2333; }
    .head { width: 100%; border-bottom: 2px solid #4843a5; padding-bottom: 8px; margin-bottom: 10px; }
    .head td { vertical-align: middle; }
    h1 { font-size: 16px; margin: 0 0 2px; color: #060331; }
    .muted { color: #6a7389; }
    table.data { width: 100%; border-collapse: collapse; }
    table.data th { background: #4843a5; color: #fff; text-align: left; padding: 6px 7px; font-size: 9.5px; }
    table.data td { border-bottom: 1px solid #e2e5f0; padding: 5px 7px; vertical-align: top; }
    .foot { position: fixed; bottom: -22px; left: 0; right: 0; font-size: 8.5px; color: #6a7389; text-align: center; }
</style>
</head>
<body>
<table class="head"><tr>
    @if(extension_loaded('gd'))
    <td style="width:56px"><img src="{{ public_path('images/joplc_logo.png') }}" style="height:46px"></td>
    @endif
    <td>
        <h1>Department Files</h1>
        <div class="muted">Jamuna Oil PLC. &middot; MIS &amp; IT Department</div>
        <div class="muted">{{ $files->count() }} {{ \Illuminate\Support\Str::plural('file', $files->count()) }}@if($section) &middot; Section: {{ $section }}@endif @if($q) &middot; Search: {{ $q }}@endif</div>
    </td>
</tr></table>

<table class="data">
    <thead><tr><th style="width:5%">#</th><th>File title</th><th style="width:17%">File number</th><th style="width:13%">Shelf no</th><th style="width:20%">Section</th></tr></thead>
    <tbody>
    @forelse($files as $f)
        <tr><td @if($loop->even) style="background:#f6f7fc" @endif>{{ $loop->iteration }}</td>@php $bg = $loop->even ? 'background:#f6f7fc' : ''; @endphp<td style="{{ $bg }}">{{ $f->title }}</td><td style="{{ $bg }}">{{ $f->file_no }}</td><td style="{{ $bg }}">{{ $f->shelf_no }}</td><td style="{{ $bg }}">{{ $f->section }}</td></tr>
    @empty
        <tr><td colspan="5" class="muted">No files found.</td></tr>
    @endforelse
    </tbody>
</table>

@unless($mpdf)<div class="foot">Generated {{ $generatedAt->format('d M Y h:i A') }} (GMT+6) by {{ $generatedBy }}</div>@endunless
</body>
</html>
