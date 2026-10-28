<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="60">
    <title>Under maintenance – JOPLC</title>
    <link rel="icon" type="image/png" href="{{ asset('images/joplc_logo.png') }}">
    {{-- Standalone page: shown by "php artisan down", so it must not use the session, login, database or layout. --}}
    <style>
        :root { --bg: #f4f6fa; --card: #ffffff; --text: #1f2937; --muted: #6b7280; --brand: #0d6efd; --line: #e5e7eb; }
        @media (prefers-color-scheme: dark) { :root { --bg: #111827; --card: #1f2937; --text: #f3f4f6; --muted: #9ca3af; --line: #374151; } }
        * { box-sizing: border-box; }
        html, body { height: 100%; margin: 0; }
        body { display: flex; flex-direction: column; background: var(--bg); color: var(--text); font: 15px/1.5 system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif; }
        .top { display: flex; align-items: center; gap: 10px; padding: 10px 20px; background: #0f2744; color: #fff; }
        .top img { height: 30px; width: auto; }
        .top b { font-size: 16px; letter-spacing: .3px; }
        .top .company { margin-left: auto; font-size: 13px; opacity: .85; }
        main { flex: 1; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .box { max-width: 520px; width: 100%; text-align: center; background: var(--card); border: 1px solid var(--line); border-radius: 14px; padding: 36px 28px; box-shadow: 0 6px 24px rgba(0,0,0,.06); }
        .ico { width: 64px; height: 64px; margin: 0 auto 16px; color: var(--brand); }
        h1 { font-size: 22px; margin: 0 0 8px; }
        p { margin: 0 0 10px; color: var(--muted); }
        .hint { font-size: 13px; margin-top: 18px; padding-top: 14px; border-top: 1px solid var(--line); }
        footer { text-align: center; padding: 12px; font-size: 12px; color: var(--muted); }
    </style>
</head>
<body>
    <div class="top">
        <img src="{{ asset('images/joplc_logo.png') }}" alt="JOPLC">
        <b>JOPLC.</b>
        <span class="company">Jamuna Oil PLC.</span>
    </div>
    <main>
        <div class="box">
            <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4l-2.4 2.4-2.1-.6-.6-2.1z"/></svg>
            <h1>We’re making improvements</h1>
            <p>The IT Service Desk is temporarily under maintenance. Please check back in a little while.</p>
            <p class="hint">This page refreshes by itself every minute. If your request is urgent, please contact the MIS &amp; IT Department directly.</p>
        </div>
    </main>
    <footer>Developed by MIS &amp; IT Department of JOPLC.</footer>
</body>
</html>
