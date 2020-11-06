<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleXHakAkses extends Model
{
    
    protected $table = 'role_x_hak_akses';
    public $timestamps = true;
    protected $guarded=[];

    public function hakAkses(){
		
		return $this->belongsTo('App\Models\HakAkses', 'kode','kode_hak_akses');
	
    }
    public function role(){
		
		return $this->belongsTo('App\Models\Role','kode', 'kode_role');
	
    }
}
