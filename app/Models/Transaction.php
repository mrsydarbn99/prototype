<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','cabinet_id', 'barcode', 'action'];

    public function cabinet()
    {
        return $this->belongsTo(Cabinet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}