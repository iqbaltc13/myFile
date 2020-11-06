<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;

class PermissionUser extends LaratrustPermission
{
	protected $table = 'permission_user';
    protected $fillable = [
        'permission_id', 'user_id', 'user_type',
    ];
}
