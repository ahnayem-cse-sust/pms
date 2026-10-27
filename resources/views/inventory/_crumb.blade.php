{{-- Asset type › Category › Sub category. Pass: e (equipment with assetType, category, subcategory loaded). --}}
@if($e->assetType || $e->category || $e->subcategory)
<div class="inv-crumb">@if($e->assetType)<span>{{ $e->assetType->name }}</span>@endif @if($e->category)<span>{{ $e->category->name }}</span>@endif @if($e->subcategory)<span>{{ $e->subcategory->name }}</span>@endif</div>
@else
<span class="text-muted">—</span>
@endif
