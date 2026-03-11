<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'complaint_id',
        'amount',
        'payment_date',
        'payment_made_by',
    ];

    public function complaint()
    {
        return $this->belongsTo(Complain::class, 'complaint_id');
    }
}