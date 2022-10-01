<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Order;
use app\Models\Address;

class Customer extends Model
{
    use HasFactory;

    public function order(){
        return $this->belongsToMany(Order::class);
    }

    public function address(){
        return $this->belongsToMany(Address::class);
    }




}
