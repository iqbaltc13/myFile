<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fext extends Model
{
    protected $table = 'fexts';
    protected $fillable = [
        'name',
    ];
    // public function ftypes(){
    // 	return $this->hasOne('App\Models\Ftype','ftype_id','id');
    // }
    public function ftypes()
    {
        return $this->belongsTo('App\Models\Ftype', 'ftype_id', 'id');
    }
}
