<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditor extends Model
{
    use HasFactory;

    public function address(){
        return $this->hasOne(Address::class, 'auditor_id');
    }

    public function profile(){
        return $this->hasOne(Profile::class, 'auditor_id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function confirmationRequest(){
        return $this->hasMany(ConfirmationRequest::class, 'auditor_id');
    }

}
