<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRecord extends Model
{
    protected $table = 'user_records';
    protected $fillable = [
        'user_id','activity','device','notes','url','latitude','longitude','execution_time'
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
