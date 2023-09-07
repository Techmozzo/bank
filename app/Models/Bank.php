<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    
    protected $fillable = ['email', 'password', 'must_change_password', 'bank_id', 'is_verified', 'is_blocked'];

}
