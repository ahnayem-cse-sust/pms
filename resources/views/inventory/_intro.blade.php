{{-- One plain sentence under the page title: what this page is for and what to do here. Pass: text (and optional tip). --}}
<div class="inv-intro"><x-icon name="info" :size="16"/><div>{{ $text }}@if(!empty($tip)) <span class="inv-intro-tip">{{ $tip }}</span>@endif</div></div>
