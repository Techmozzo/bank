<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'banker_roles';

    protected $fillable = ['name', 'description'];

    public function user(){
        return $this->hasOne(User::class);
    }
}
