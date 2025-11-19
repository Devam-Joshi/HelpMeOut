<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $fillable =[
        'name'
    ];

    public function users()
{
    return $this->belongsToMany(User::class, 'category_user');
}

}
