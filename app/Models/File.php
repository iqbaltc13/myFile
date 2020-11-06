<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';
    protected $fillable = [
        'folder','path','path_thumbnail','ftype_id','full_path',
        'ext','full_path_thumbnail','caption','ftype_id','user_id','size_in_bytes'
    ];

    public function fileType(){
        return $this->belongsTo('App\FileType','file_type_id','id');
    }
}
