<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class ImportBatch extends Model
{
    protected $table = 'inv_import_batches';
    protected $guarded = [];
    protected $casts = ['posted_at' => 'datetime'];

    public function uploader() { return $this->belongsTo(\App\Models\User::class, 'uploaded_by'); }
}
