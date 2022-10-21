<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function serviceRate(){
        return $this->belongsTo(ServiceRate::class);
    }

    // public function clothLists(){
    //     return $this->belongsTo(ClothList::class);
    // }
}
