<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Replaces the single *.manage permissions with Read / Add / Update / Delete permissions (roles and per-user overrides). */
return new class extends Migration
{
    private array $map = [
        'user.manage' => ['user.view', 'user.create', 'user.update'],
        'role.manage' => ['role.view', 'role.create', 'role.update', 'role.delete'],
        'lookup.manage' => ['lookup.view', 'lookup.create', 'lookup.update'],
        'settings.manage' => ['settings.view', 'settings.update'],
    ];

    private function convert(?string $json, array $map): ?string
    {
        if ($json === null) return null;
        $in = json_decode($json, true) ?: [];
        $out = [];
        foreach ($in as $p) {
            foreach ($map[$p] ?? [$p] as $q) $out[] = $q;
        }
        return json_encode(array_values(array_unique($out)));
    }

    public function up(): void
    {
        foreach (DB::table('roles')->get() as $r) {
            DB::table('roles')->where('id', $r->id)->update(['permissions' => $this->convert($r->permissions, $this->map), 'updated_at' => now()]);
        }
        foreach (DB::table('users')->get(['id', 'extra_permissions', 'denied_permissions']) as $u) {
            DB::table('users')->where('id', $u->id)->update([
                'extra_permissions' => $this->convert($u->extra_permissions, $this->map),
                'denied_permissions' => $this->convert($u->denied_permissions, $this->map),
            ]);
        }
    }

    public function down(): void
    {
        $back = [];
        foreach ($this->map as $old => $new) foreach ($new as $n) $back[$n] = [$old];
        foreach (DB::table('roles')->get() as $r) {
            DB::table('roles')->where('id', $r->id)->update(['permissions' => $this->convert($r->permissions, $back)]);
        }
        foreach (DB::table('users')->get(['id', 'extra_permissions', 'denied_permissions']) as $u) {
            DB::table('users')->where('id', $u->id)->update([
                'extra_permissions' => $this->convert($u->extra_permissions, $back),
                'denied_permissions' => $this->convert($u->denied_permissions, $back),
            ]);
        }
    }
};
