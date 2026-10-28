<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * New permission ticket.list.all: shows every request in the All Requests list without letting the user open it.
 * Everyone who can already view all requests keeps the list; IT Team Members (role it_member) get the list and its
 * sidebar menu while still opening only the requests they are on the team of (ticket.view.assigned).
 */
return new class extends Migration
{
    private function add(?string $json, array $add): string
    {
        return json_encode(array_values(array_unique(array_merge(json_decode($json ?? '[]', true) ?: [], $add))));
    }

    public function up(): void
    {
        $now = now();
        foreach (DB::table('roles')->get() as $role) {
            $perms = json_decode($role->permissions, true) ?: [];
            $add = [];
            if (in_array('ticket.view.all', $perms, true)) $add[] = 'ticket.list.all';
            if ($role->slug === 'it_member') array_push($add, 'ticket.list.all', 'menu.all_requests');
            if ($add) DB::table('roles')->where('id', $role->id)->update(['permissions' => $this->add($role->permissions, $add), 'updated_at' => $now]);
        }

        // Users who were individually granted "view all requests" keep the list too.
        foreach (DB::table('users')->whereNotNull('extra_permissions')->get(['id', 'extra_permissions']) as $u) {
            $extra = json_decode($u->extra_permissions, true) ?: [];
            if (in_array('ticket.view.all', $extra, true)) {
                DB::table('users')->where('id', $u->id)->update(['extra_permissions' => $this->add($u->extra_permissions, ['ticket.list.all'])]);
            }
        }
    }

    public function down(): void
    {
        $strip = fn (?string $json) => json_encode(array_values(array_diff(json_decode($json ?? '[]', true) ?: [], ['ticket.list.all'])));
        foreach (DB::table('roles')->get() as $r) {
            $perms = json_decode($r->permissions, true) ?: [];
            if ($r->slug === 'it_member') $perms = array_diff($perms, ['menu.all_requests']);
            DB::table('roles')->where('id', $r->id)->update(['permissions' => $strip(json_encode(array_values($perms)))]);
        }
        foreach (DB::table('users')->whereNotNull('extra_permissions')->get(['id', 'extra_permissions']) as $u) {
            DB::table('users')->where('id', $u->id)->update(['extra_permissions' => $strip($u->extra_permissions)]);
        }
    }
};
