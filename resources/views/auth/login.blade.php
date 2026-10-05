@extends('layouts.app')
@section('title', 'Sign in')
@section('content')
<div class="login-wrap">
    <section class="login-hero">
        <img src="{{ asset('images/joplc_logo.png') }}" alt="Jamuna Oil" class="brand-logo brand-logo-lg mb-4">
        <h1>Jamuna Oil PLC.<br>IT Service Desk</h1>
        <p>Report an IT problem or request a service, follow it to resolution, and confirm when it is fixed.</p>
        <ul class="list-unstyled mt-3">
            <li>✓ Track every request from submission to closure</li>
            <li>✓ Clear ownership and response targets</li>
            <li>✓ Complete history of every change</li>
        </ul>
    </section>
    <section class="login-form">
        <div style="width:100%;max-width:380px">
            <h3 class="mb-1">Welcome back</h3>
            <p class="text-muted mb-4">Sign in with your company email.</p>
            <form method="POST" action="{{ route('login') }}">@csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg" required autofocus>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" required>
                </div>
                <button class="btn btn-primary btn-lg w-100">Sign in</button>
            </form>
        </div>
        <div class="login-foot">Developed by MIS &amp; IT Department of JOPLC.</div>
    </section>
</div>
@endsection
