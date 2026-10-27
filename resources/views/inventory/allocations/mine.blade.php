@extends('layouts.app')
@section('title', 'My Equipment')
@section('content')
<table class="table table-sm bg-white align-middle"><thead class="table-light"><tr><th>Equipment</th><th>Classification</th><th class="text-end">Quantity</th><th>Held by</th><th>Since</th></tr></thead><tbody>
@forelse($rows as $x)<tr><td>{{ $x->equipment->name }}<div class="text-muted small">{{ $x->equipment->brand }} {{ $x->equipment->model }}</div>@if($x->serial_no)<div class="text-muted small">S/N {{ $x->serial_no }}</div>@endif</td><td class="small">{{ $x->equipment->classification }}</td>
<td class="text-end">{{ \App\Support\Inv::qty($x->held) }} {{ $x->equipment->unit }}</td><td>{{ $x->holder }}</td><td>{{ $x->since ? \Illuminate\Support\Carbon::parse($x->since)->format('d M Y') : '' }}</td></tr>
@empty<tr><td colspan="5" class="text-center text-muted py-4">Nothing is allocated to you or your department.</td></tr>@endforelse</tbody></table>
@endsection
