<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\File;
use App\Models\Fext;
use App\Models\Ftype;
use App\Models\FextFtype;
use Auth;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\Exception\NotReadableException;

class UploadFileController extends Controller
{
    //
    public function uploadFile(Request $request)
	{		
		$rules = [
	            'file' => 'required',
	            'folder' => 'required|string'
	        ];

		$validator =  $this->customValidation($request, $rules);

		if ($validator !== TRUE) {
            return $validator;
		}
	    if ($request->file('file')) {
	    	$uuid 					= Uuid::uuid4()->toString();
	    	$file 					= $request->file('file');
            $ext 					= $request->file->extension();
            $fext                   = Fext::where('name',$ext)->first();
            $ftype                  = $fext->ftypes;
            if(!$ftype){
                return $this->failure('invalid file');
            }
			try {
                if(($ftype->name == 'image')||$ftype->name == 'images'){
                    $file = $this->saveImage($uuid,$file,$ext,$request,$ftype);
                }else{
                    $file = $this->saveFile($uuid,$file,$ext,$request,$ftype);
                }
            } catch (\Throwable $th) {
                return $this->failure($th->getMessage());
            }

		    return $this->success('File berhasil diupload.', $file);
		}
		else
			return $this->failure();
	}

	public function generateThumbnail(Request $request){
		$gambars 	= Gambar::whereNull('path_thumbnail')->get();
		foreach ($gambars as $gambar) {
			try {
				$thumb 					= Image::make($gambar->path)->resize(100, 100, function ($constraint) {
		            $constraint->aspectRatio(); //maintain image ratio
		        });
		        $thumb->save(public_path($path).'thumb_'.$name);
		        $gambarx					= Gambar::find($gambar->id);
		        $gambarx->path_thumbnail 	= '/uploads/'.$gambar->folder.'/thumb_'.$gambar->id.'.jpeg';
		        $gambarx->ext 				= 'jpeg';
		        $gambarx->save();
			}catch(NotReadableException $e) {
			    // return $e->getMessage();
			}
			
		}
		return $this->success(@count($gambars).' ditampilkan.', $gambars);
	}

	public function generateFullPath(Request $request){
		$gambars 	= Gambar::whereNull('full_path')->get();
		foreach ($gambars as $gambar) {
			$gambar 						= Gambar::find($gambar->id);
			$gambar->full_path 				= asset($gambar->path);
			$gambar->full_path_thumbnail 	= asset($gambar->path_thumbnail);
			$gambar->save();
		}
		$gambars 	= Gambar::whereNull('full_path')->get();
		return $this->success(@count($gambars).' gambar belum full path.');
    }
    
    private function saveImage($uuid,$file,$ext,$request,$ftype)
    {
        $imageManager 			= new ImageManager(array('driver' => 'imagick'));
        $thumb 					= Image::make($file->getRealPath())->resize(200, 200, function ($constraint) {
            $constraint->aspectRatio(); //maintain image ratio
        });
        $name   				= $uuid.'.'.$ext;
        $path   				= '/uploads/'.$request->folder.'/';
        $size                   = $request->file('file')->getSize();
        $file->move(public_path($path), $name);
        $thumb->save(public_path($path).'thumb_'.$name);
        $gambar = File::create([
                'id' 				   => $uuid,
                'folder' 			   => $request->folder,
                'path' 				   => $path.$name,
                'path_thumbnail'	   => $path.'thumb_'.$name,
                'ftype_id'             => $ftype->id,
                'user_id'              => Auth::user()->id,
                'ext'				   => $ext,
                'full_path' 		   => asset($path.$name),
                'full_path_thumbnail'  => asset($path.'thumb_'.$name),
                'size_in_bytes'        => $size,
            ]);
        
        return $gambar;
    }

    private function saveFile($uuid,$file,$ext,$request,$ftype)
    {
        // $imageManager 			= new ImageManager(array('driver' => 'imagick'));
        // $thumb 					= Image::make($file->getRealPath())->resize(200, 200, function ($constraint) {
        //     $constraint->aspectRatio(); //maintain image ratio
        // });
        $name   				= $uuid.'.'.$ext;
        $path   				= '/uploads/'.$request->folder.'/';
        $size                   = $request->file('file')->getSize();
        $file->move(public_path($path), $name);
        $upload = File::create([
                'id' 				   => $uuid,
                'folder' 			   => $request->folder,
                'path' 				   => $path.$name,
                'path_thumbnail' 				   => $path.$name,
                // 'path_thumbnail'	   => $path.'thumb_'.$name,
                'ext'				   => $ext,
                'user_id'              => Auth::user()->id,
                'ftype_id'             => $ftype->id,
                'full_path' 		   => asset($path.$name),
                'full_path_thumbnail' 		   => asset($path.$name),
                'size_in_bytes'        => $size,
                // 'full_path_thumbnail'  => asset($path.'thumb_'.$name),
            ]);

        return $upload;
    }
}
