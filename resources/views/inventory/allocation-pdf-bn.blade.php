<!DOCTYPE html>
<html lang="bn"><head><meta charset="utf-8"><title>হস্তান্তর {{ $entry }}</title>
@php
    // Bangla digits and month names for dates and quantities; IDs, serial numbers and names stay as they are
    $bn = fn ($v) => strtr((string) $v, ['0' => '০', '1' => '১', '2' => '২', '3' => '৩', '4' => '৪', '5' => '৫', '6' => '৬', '7' => '৭', '8' => '৮', '9' => '৯']);
    $months = ['জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
    $dt = fn ($d) => $bn($d->format('d')).' '.$months[(int) $d->format('n') - 1].' '.$bn($d->format('Y'));
@endphp
<style>
    body { font-family: kalpurush; font-size: 11pt; color: #1c2333; }
    h1 { font-size: 17pt; margin: 0; color: #060331; text-align: center; }
    table { width: 100%; border-collapse: collapse; }
    .meta td { padding: 3px 6px; border: 1px solid #b8bfcd; vertical-align: top; }
    .meta td.k { width: 22%; background: #f1f3f8; font-weight: bold; }
    .items th { background: #060331; color: #ffffff; padding: 5px 6px; text-align: left; font-size: 10.5pt; }
    .items td { padding: 4px 6px; border: 1px solid #b8bfcd; vertical-align: top; }
    .note { font-size: 11.5pt; color: #434b60; }
    .sig td { width: 33%; text-align: center; padding: 0 12px; }
    .sig div { border-top: 1px solid #111111; padding-top: 4px; font-size: 11pt; }
    .sig div.st { border-top: 0; padding-top: 0; font-size: 10pt; color: #434b60; }
</style>
</head><body>
<table style="margin-bottom:2px"><tr>
    <td style="width:60px"><img src="{{ public_path('images/joplc_logo.png') }}" style="height:56px"></td>
    <td style="vertical-align:middle;text-align:center">
        <div style="font-size:15pt;font-weight:bold;color:#060331">যমুনা অয়েল পিএলসি.</div>
        <div style="font-size:9.5pt;color:#434b60">(বাংলাদেশ পেট্রোলিয়াম কর্পোরেশনের একটি অঙ্গ প্রতিষ্ঠান)</div>
        <div style="font-size:9.5pt;color:#434b60">আগ্রাবাদ বাণিজ্যিক এলাকা, চট্টগ্রাম</div>
        <div style="font-size:10.5pt;font-weight:bold">এমআইএস ও আইটি বিভাগ</div>
        <div style="font-size:9.5pt;color:#434b60">www.jamunaoil.gov.bd</div>
    </td>
    <td style="width:60px"></td>
</tr></table>
<h1 style="margin:4px 0 8px">কম্পিউটার ও কম্পিউটার সামগ্রী গ্রহণ ফর্ম</h1>
<table class="meta">
<tr><td class="k">প্রাপক</td><td>{{ $first->holder_name }}@if($first->holderUser) – {{ $first->holderUser->employee_id }}@endif</td><td class="k">বরাদ্দ নাম্বার</td><td>{{ $entry }}</td></tr>
<tr><td class="k">বিভাগ</td><td>{{ $first->holderUser->department->name ?? ($first->holderDepartment->name ?? '—') }}</td><td class="k">তারিখ</td><td>{{ $dt($first->moved_on) }}</td></tr>
<tr><td class="k">অবস্থান</td><td>{{ $first->holderUser->location->name ?? '—' }}</td><td class="k">রেফারেন্স</td><td>{{ $first->reference_no ?: '—' }}</td></tr>
<tr><td class="k">আইটেম সংখ্যা</td><td>{{ $bn($lines->count()) }}</td><td></td><td></td></tr>
</table>
<table class="items" style="margin-top:10px"><thead><tr><th style="width:6%">ক্রম</th><th style="width:34%">ডিভাইস এর নাম</th><th style="width:17%">আইটেম আইডি/পরিমান</th><th style="width:17%">সিরিয়াল নম্বর</th><th>উদ্দেশ্য</th></tr></thead><tbody>
@foreach($lines as $i => $m)
<tr><td>{{ $bn($i + 1) }}</td><td>{{ $m->equipment->name }}</td>
<td>@if($m->serial_no)<strong>{{ $m->serial_no }}</strong>@else<strong>{{ $bn(\App\Support\Inv::qty(abs($m->qty))) }}</strong> {{ $m->equipment->unit }}@endif</td>
<td>{{ $m->device_serial_no ?: '—' }}</td>
<td>{{ $m->remarks ?: '—' }}</td></tr>
@endforeach
</tbody></table>
<table class="sig" style="margin-top:110px"><tr><td></td><td></td><td><div>(মোঃ মেসবাহ উদ্দীন)</div><div class="st">ডিজিএম (এমআইএস এন্ড আইটি)</div></td></tr></table>
<table class="sig" style="margin-top:118px"><tr><td><div>প্রেরণকারী</div><div class="st">(স্বাক্ষর ও সিল)</div></td><td><div>মাধ্যম</div><div class="st">(স্বাক্ষর ও সিল)</div></td><td><div>গ্রহণকারী</div><div class="st">(স্বাক্ষর ও সিল)</div></td></tr></table>
<p class="note" style="margin-top:27px">উপরোক্ত মালামালসমূহ গ্রহণ করে এই প্রাপ্তিস্বীকার পত্রের মূল কপিটি কোম্পানির প্রধান কার্যালয়ের এমআইএস এন্ড আইটি বিভাগ বরাবর ফেরত পাঠানোর অনুরোধ করা হলো।</p>
</body></html>
