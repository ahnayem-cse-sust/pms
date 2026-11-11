{{-- Short list of equipment with quantities, three at most then "+N more". Pass: items (collection of ['name', 'qty']). --}}
@php $shown = $items->take(3); $more = $items->count() - $shown->count(); @endphp
@foreach($shown as $it)<div class="d-flex justify-content-between gap-3"><span class="text-truncate" style="max-width:260px" title="{{ $it['name'] }}">{{ $it['name'] }}</span><span class="inv-q text-nowrap">× {{ \App\Support\Inv::qty($it['qty']) }}</span></div>@endforeach
@if($more > 0)<div class="inv-sub">+ {{ $more }} more {{ $more === 1 ? 'item' : 'items' }}</div>@endif
