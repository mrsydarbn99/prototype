<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefType extends Model
{
    protected $fillable = ['name'];

    public function cabinets()
    {
        return $this->hasMany(Cabinet::class, 'ref_type_id');
    }
}