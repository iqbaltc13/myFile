<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceInformation extends Model
{
    protected $table = 'device_information';
    protected $fillable = [
        'device_name','device_id','operating_system','latitude','longitude','app_version_code','app_version_name','battery_percentage'
    ];
}