<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'inv_documents';
    protected $guarded = [];
    protected $casts = ['created_at' => 'datetime'];

    public $timestamps = false;
    public function uploader() { return $this->belongsTo(\App\Models\User::class, 'uploaded_by'); }
}
