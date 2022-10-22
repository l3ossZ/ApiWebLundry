<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRate extends Model
{
    use HasFactory;

    public function clothLists(){
        return $this->belongsTo(ClothList::class);
    }

    public function category(){
        return $this->hasMany(Category::class);
    }


}
