<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['old_values' => 'array', 'new_values' => 'array', 'created_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }

    /** Who / what / when / old / new / IP */
    public static function record(string $event, $model = null, ?array $old = null, ?array $new = null): void
    {
        static::create([
            'user_id' => auth()->id(),
            'event' => $event,
            'auditable_type' => $model ? class_basename($model) : null,
            'auditable_id' => $model?->getKey(),
            'old_values' => $old,
            'new_values' => $new,
            'ip_address' => request()?->ip(),
            'user_agent' => substr((string) request()?->userAgent(), 0, 255),
            'created_at' => now(),
        ]);
    }
}
