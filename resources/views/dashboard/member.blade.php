@extends('layouts.app')
@section('title', 'My Tickets')
@section('content')
<section class="dash-section">@include('dashboard._stats', ['stats' => $stats])</section>

<section class="dash-section">
    <div class="section-head">
        <div>
            <h5 class="section-title">Open work</h5>
            <div class="section-sub">Earliest due date first.</div>
        </div>
    </div>
    @include('tickets._table', ['tickets' => $open, 'mode' => 'tasks'])
    <div class="mt-3">{{ $open->links() }}</div>
</section>
@endsection
