<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabinet extends Model
{
    protected $fillable = [
        'ref_type_id',
        'ref_location_id',
        'ref_cabinet_id',
        'cabinet_no',
        'is_occupied',
        'barcode'
    ];

    public function type()
    {
        return $this->belongsTo(RefType::class, 'ref_type_id');
    }

    public function location()
    {
        return $this->belongsTo(RefLocation::class, 'ref_location_id');
    }

    public function cabinetRef()
    {
        return $this->belongsTo(RefCabinet::class, 'ref_cabinet_id');
    }
}