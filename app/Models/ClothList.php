<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClothList extends Model
{
    use HasFactory;

    public function serviceRate(){
        return $this->belongsTo(ServiceRate::class);
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
}
