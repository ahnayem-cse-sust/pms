{{-- Stock level bar (only when a minimum level is set). Pass: e (equipment). --}}
@if((float) $e->min_stock > 0)
<div class="inv-meter is-{{ \App\Support\Inv::state($e->stock_qty, $e->min_stock) }}" title="{{ \App\Support\Inv::qty($e->stock_qty) }} in stock, minimum {{ \App\Support\Inv::qty($e->min_stock) }}"><span style="width:{{ \App\Support\Inv::fill($e->stock_qty, $e->min_stock) }}%"></span></div>
@endif
