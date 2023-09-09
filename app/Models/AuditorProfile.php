<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditorProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'first_name', 'last_name', 'middle_name', 'phone', 'identification', 'avatar', 'gender', 'country_of_origin', 'date_of_birth', 'occupation', 'marital_status', 'auditor_id'
    ];

}
