<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** A section of a department (Configuration → Sections). */
class Section extends Model
{
    protected $guarded = [];
    public function department() { return $this->belongsTo(Department::class); }
}
