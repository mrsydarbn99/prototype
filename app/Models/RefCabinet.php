<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefCabinet extends Model
{
    protected $fillable = ['code'];

    public function cabinets()
    {
        return $this->hasMany(Cabinet::class, 'ref_cabinet_id');
    }
}