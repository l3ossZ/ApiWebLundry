<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Order;
use app\Models\Address;

class Customer extends Model
{
    use HasFactory;

    public function orders(){
        return $this->belongsToMany(Order::class);
    }

    public function address(){
        return $this->belongsToMany(Address::class);
    }

    public function serviceRate(){
        return $this->belongsTo(ServiceRate::class);
    }



}
