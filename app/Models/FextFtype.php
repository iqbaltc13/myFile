<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FextFtype extends Model
{
    protected $table = 'fext_ftype';
    protected $fillable = [
        'ftype_id','fext_id'
    ];
}
