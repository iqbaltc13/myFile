<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;

class RoleUser extends LaratrustPermission
{
	protected $table = 'role_user';
    protected $fillable = [
        'role_id', 'user_id', 'user_type',
    ];
}
