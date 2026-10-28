<tr class="row-link" data-href="{{ route('inv.records.show', $m) }}">
    <td class="text-nowrap"><div class="d-flex align-items-center gap-2"><span class="type-ico ti-{{ \App\Support\Inv::tone($m->type) }}"><x-icon :name="\App\Support\Inv::icon($m->type)" :size="15"/></span><div><a href="{{ route('inv.records.show', $m) }}" class="ticket-link">{{ $m->ref }}</a><div class="inv-sub">{{ $m->moved_on->format('d M Y') }}@if($m->entry_no) · {{ $m->entry_no }}@endif</div></div></div></td>
    <td>{{ \App\Support\Inv::pill($m->type) }}@if($m->serial_no)<div class="inv-sub"><span class="inv-sn">Asset ID {{ $m->serial_no }}</span>@if($m->device_serial_no) · Serial {{ $m->device_serial_no }}@endif</div>@endif</td>
    <td class="text-end"><span class="inv-q {{ $m->qty > 0 ? 'pos' : ($m->qty < 0 ? 'neg' : '') }}">{{ $m->qty > 0 ? '+' : '' }}{{ \App\Support\Inv::qty($m->qty) }}</span><div class="inv-sub">balance {{ \App\Support\Inv::qty($m->balance_after) }}</div></td>
    <td>{{ $m->holder_name ?: '—' }}<div class="inv-sub">{{ trim($m->reference_no.' '.$m->party) ?: '' }}@if($m->remarks) · {{ $m->remarks }}@endif</div><div class="inv-sub">by {{ $m->user->name ?? '' }}</div></td>
    <td class="text-end"><a class="btn btn-sm btn-outline-primary" href="{{ route('inv.records.show', $m) }}"><x-icon name="eye" :size="14"/> View</a></td>
</tr>
