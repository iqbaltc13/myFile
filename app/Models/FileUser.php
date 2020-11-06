<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileUser extends Model
{
    protected $table = 'file_user';
    protected $fillable = [
        'file_id','user_id'
    ];
}
