@extends('layouts.app')
@section('title', 'Assignment Board')
@section('nofooter', '1')
@section('content')
<div class="text-muted small mb-3">Open requests, oldest first.@if($board['canAssign']) Drag an employee's name to reorder the columns.@endif</div>

@include('dashboard._board', ['board' => $board, 'full' => true])
@endsection
