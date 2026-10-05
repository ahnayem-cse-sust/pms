@extends('layouts.app')
@section('title', 'My Tickets')
@section('content')
<div class="mb-4">@include('dashboard._stats', ['stats' => $stats])</div>
<h6 class="mb-2">Open work <span class="text-muted fw-normal">– highest priority and earliest due first</span></h6>
@include('tickets._table', ['tickets' => $open])
@endsection
