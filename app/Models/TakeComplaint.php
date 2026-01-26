<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakeComplaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'agent_id',
    ];

    public function complaint()
    {
        return $this->belongsTo(Compalin::class, 'complaint_id');
    }

}
