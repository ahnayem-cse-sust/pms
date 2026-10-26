@props(['id', 'icon', 'label', 'open' => false])
{{-- Parent menu: only one parent is expanded at a time (data-bs-parent). The group holding the current page starts open. --}}
<li>
    <a class="nav-link nav-parent {{ $open ? 'parent-active' : 'collapsed' }}" data-bs-toggle="collapse" href="#nav-{{ $id }}" role="button" aria-expanded="{{ $open ? 'true' : 'false' }}" aria-controls="nav-{{ $id }}">
        <x-icon :name="$icon"/> {{ $label }}
    </a>
    {{-- The collapsing element carries no margin/padding, so its height animates from 0 smoothly; the spacing lives on the inner list. --}}
    <div class="sub-wrap collapse {{ $open ? 'show' : '' }}" id="nav-{{ $id }}" data-bs-parent="#sideMenu">
        <ul class="nav flex-column sub">
            {{ $slot }}
        </ul>
    </div>
</li>
