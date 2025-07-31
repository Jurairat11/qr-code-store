<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $fillable = ['part_no', 'store_id', 'pac_qty'];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
