<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    protected $table = 'error_log';
    protected $fillable = [
        'message','line','file','url','input','user_agent','http_code','code'
    ];
}