<?php

namespace App\Models;

use App\Interfaces\Types;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name','email', 'phone', 'website', 'company_code', 'logo', 'address', 'city', 'state', 'country', 'zip', 'is_verified', 'administrator_id'];

}
