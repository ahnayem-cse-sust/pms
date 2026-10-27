<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    protected $table = 'inv_issues';
    protected $guarded = [];
    protected $casts = ['required_date' => 'date', 'approved_at' => 'datetime'];

    public function lines() { return $this->hasMany(IssueLine::class); }
    public function requester() { return $this->belongsTo(\App\Models\User::class, 'requested_by'); }
    public function recipient() { return $this->belongsTo(\App\Models\User::class, 'recipient_user_id'); }
    public function department() { return $this->belongsTo(\App\Models\Department::class); }
    public function location() { return $this->belongsTo(Location::class); }
    public function approver() { return $this->belongsTo(\App\Models\User::class, 'approved_by'); }
}
