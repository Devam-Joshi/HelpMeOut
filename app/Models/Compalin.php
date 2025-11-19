<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compalin extends Model
{
    protected $table = 'complains';
    public $fillable = ['title','category_id','user_id','image','video'];
}
