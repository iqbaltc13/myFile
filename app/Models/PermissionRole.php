<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;

class PermissionRole extends LaratrustPermission
{
	protected $table = 'permission_role';
    protected $fillable = [
        'permission_id', 'role_id',
    ];
}
