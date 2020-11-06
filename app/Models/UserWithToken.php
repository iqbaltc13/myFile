<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserWithToken extends Model
{
	protected $table = 'users';
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'is_active','built_in',
        'email_verified_at','phone_number_verified_at','last_access','last_signedin',
        'last_update_location','latitude','longitude',
        'access_token'
    ];
    protected $hidden = [
        'password'
    ];
}
