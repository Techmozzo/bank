<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Banker extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'email' , 'password', 'is_verified', 'is_blocked','role_id', 'must_change_password', 'bank_id', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function name(){
        return $this->profile->first_name.' '. $this->profile->last_name;
    }

    public function initials(){
        return substr($this->profile->first_name, 0, 1) .' '. substr($this->profile->last_name, 0, 1);
    }

    public function address(){
        return $this->hasOne(Address::class, 'banker_id');
    }

    public function profile(){
        return $this->hasOne(Profile::class, 'banker_id');
    }

    public function bank(){
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function confirmationRequest(){
        return $this->hasMany(ConfirmationRequest::class, 'bank_id');
    }

    public  function role(){
        return $this->belongsTo(Role::class);
    }

    public function hasRole($role){
        return null !== $this->role()->where('name', $role)->first();
    }

}
