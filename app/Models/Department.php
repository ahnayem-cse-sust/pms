<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];
    public function users() { return $this->hasMany(User::class); }
    public function sections() { return $this->hasMany(Section::class); }
}
