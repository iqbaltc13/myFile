<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HakAkses extends Model
{
    protected $table = 'master_hak_akses';
    public $timestamps = true;
    protected $guarded=[];


    public function roleXHakAkses(){
		
		return $this->hasMany('App\Models\RoleXHakAkses', 'kode_hak_akses','kode');
	
	}
}
