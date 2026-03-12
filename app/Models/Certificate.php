<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'complaint_id',
        'certificate_number',
        'pdf_name',
        'issued_to',
        'issue_date',
        'no_of_pc',
        'serial_no',
        'due_date',
        'fire_extinguisher_type',
        'next_due_date',
        'certificate_valid_date',
        'parts',
        'hy_test',
        'notes'
    ];
}
