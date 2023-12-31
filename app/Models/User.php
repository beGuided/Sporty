<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;


class User extends Authenticatable implements MustVerifyEmail
{
    
    use HasApiTokens, HasFactory, Notifiable;

   // private $clientBaseUrl= 'https://spa.test/reset-password?token=';

    protected $fillable = [ 'name','user_name','phone_number','interest'=>'Array', 'email',  'password'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function sports()
    {
        return $this->belongsToMany(Sport::class);
    }
  
}
