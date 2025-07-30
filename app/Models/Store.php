<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['store_name'];

    public function parts()
    {
        return $this->hasMany(Part::class, 'store_id');
    }
}
