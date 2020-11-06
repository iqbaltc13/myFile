<?php

namespace App\Http\Controllers\Api\V1\File;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\File;
use App\Models\Fext;
use App\Models\Ftype;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DB;
use App\Models\User;

class FileController extends Controller{
	public function upload(Request $request){
        $start = microtime(true);	
		$rules = [
            'file' 		=> 'required|file',
        ];
		$validator =  $this->customValidation($request, $rules);
		if ($validator !== TRUE) {
            return $validator;
        }
        $user 			= $request->user();
        $ext 			= $request->file('file')->getClientOriginalExtension();
        $fext 			= Fext::where('name',$ext)->first();
        if (!$fext) {
        	return $this->failure($ext.' file not supported.');
        }
        $current_time 	= Carbon::now()->toDateTimeString();
        $file_name 		= str_replace("-","",$current_time);
        $file_name 		= str_replace(" ","",$file_name);
        $file_name 		= str_replace(":","",$file_name);
        $file_name 		= $user->id.'_'.$file_name.'.'.$ext;
        $ftype 			= Ftype::where('id',$fext->ftype_id)->first();
        $path   		= '/uploads/'.$ftype->name.'/';
        $full_path 		= url('/').$path.$file_name;
        
        $request->file('file')->move(public_path($path), $file_name);
        DB::beginTransaction();
        $file 			= new File();
        $file->ftype_id = $fext->ftype_id;
        if (isset($request->caption)) {
            $file->caption  = $request->caption;
        }else{
            $file->caption  = "";
        }
        $file->full_path= $full_path;
        $file->path     = $path.$file_name;
        $file->user_id 	= $user->id;
        $file->save();
        $file 			= File::find($file->id);
        $this->insertUserRecord($user->id,'file.upload',$request->header('device'),'Upload '.$ftype->name,$request->fullUrl(),$request->header('latitude'),$request->header('longitude'),microtime(true) - $start);
        DB::commit();
        return $this->success('Success.', $file);
	}

	public function myFiles(Request $request){
        $start = microtime(true);
		$user 	= User::find($request->user()->id);
		foreach ($user->files as $value) {
			$value->fileType;
		}
        $this->insertUserRecord($user->id,'file.getmyfiles',$request->header('device'),'get myfiles',$request->fullUrl(),$request->header('latitude'),$request->header('longitude'),microtime(true) - $start);
		return $this->success('Success.', $user);
	}

}