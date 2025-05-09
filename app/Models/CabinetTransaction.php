<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabinetTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'cabinet_id',
        'user_id',
        'barcode',
        'action', // 'check_in' or 'check_out'
        'notes'
    ];

    public function cabinet()
    {
        return $this->belongsTo(Cabinet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}