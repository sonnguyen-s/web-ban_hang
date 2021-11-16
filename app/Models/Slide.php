<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table ="slide";
    public function product(){
        return $this->belongsTo('App\Models\Product','id_product','id');
    }
}
