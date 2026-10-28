@switch($h->action)
    @case('created') created the request @break
    @case('created_on_behalf') created the request on behalf of <b>{{ $h->new_value }}</b> @break
    @case('status_changed') changed status: {{ $h->old_value }} → <b>{{ $h->new_value }}</b> @break
    @case('assigned') made <b>{{ $h->new_value }}</b> the primary responsible employee @break
    @case('reassigned') changed the primary responsible employee: {{ $h->old_value }} → <b>{{ $h->new_value }}</b> @break
    @case('unassigned') unassigned the request {!! $h->old_value ? '(was with <b>'.e($h->old_value).'</b>)' : '' !!} @break
    @case('team_added') added <b>{{ $h->new_value }}</b> to the team @break
    @case('team_removed') removed <b>{{ $h->old_value }}</b> from the team @break
    @case('team_role_changed') changed the role: {{ $h->old_value }} → <b>{{ $h->new_value }}</b> @break
    @case('comment_added') added a comment @break
    @case('attachment_added') uploaded attachment(s) @break
    @case('auto_closed') (auto-closed) @break
    @default changed {{ $h->field }}: {{ $h->old_value ?? '—' }} → <b>{{ $h->new_value ?? '—' }}</b>
@endswitch
