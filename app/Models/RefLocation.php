<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefLocation extends Model
{
    protected $fillable = ['name'];

    public function cabinets()
    {
        return $this->hasMany(Cabinet::class, 'ref_location_id');
    }
}
