<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ftype extends Model
{
    protected $table = 'ftypes';
    protected $fillable = [
        'name'
    ];
    public function fexts(){
    	return $this->belongsToMany('App\Fext');
    }
}
