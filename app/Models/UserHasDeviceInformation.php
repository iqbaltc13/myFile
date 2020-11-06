<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHasDeviceInformation extends Model
{
    protected $table = 'user_has_device_information';
    protected $fillable = [
        'user_id','device_information_id'
    ];
}