<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\Models\File;

class FileController extends Controller
{
    public function __construct()
    {
        $this->route='dashboard.file.';
        $this->view='dashboard.file.';
    }
    public function index(){
        $arrReturn=[
            'sidebar' =>'file',
        ];
        return view($this->view.'index',$arrReturn);
    }
    public function datatable(Request $request){
        
        $datas  = File::with([])->where('user_id', Auth::id());
        

      

        
        $datas  = $datas->orderBy('created_at','DESC');
        
        return DataTables::of($datas)
       
        
        ->toJson();
    }
   
    public function create(Request $request){
        $arrReturn=[
            'sidebar' =>'file',
        ];
        return view($this->view.'create',$arrReturn);
    }
    public function store(Request $request){
        $this->validate($request, [
            'file' => 'required|mimes:zip',
            'name' => 'required|string|max:255',
        ]);
        $start = microtime(true);	
        
        $user 			   = $request->user();
        //$ext 			   = $request->file('file')->getClientOriginalExtension();
        $ext               = $request->file->extension();
       
        $current_time 	   = Carbon::now()->toDateTimeString();
        $file_name 		   = str_replace("-","",$current_time);
        $file_name 		   = str_replace(" ","",$file_name);
        $file_name 		   = str_replace(":","",$file_name);
        $file_name 		   = $user->id.'_'.$file_name.'_'.$request->name.'.'.$ext;
        
        $path   		   = '/uploads/zip/';
        $full_path 		   = url('/').$path.$file_name;
        
        $request->file('file')->move(public_path($path), $file_name);
        DB::beginTransaction();
        $file 			   = new File();
       
        $file->caption     = "";
        $file->name        = $user->id.'_'.$file_name.'_'.$request->name.'.'.$ext;
        $file->full_path   = $full_path;
        $file->path        = $path.$file_name;
        $file->full_path   = asset($path.$file_name);
        $file->user_id 	   = $user->id;
        $file->save();
        
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menambah file');
    }
    public function download(Request $request,$id){
        $file = File::where('id',$id)->first();
        $filePath = public_path()."/uploads/zip/".$file->name;
        $headers = array('Content-Type: application/pdf',);
        return response()->download($filePath, 'info.pdf',$headers);
       
    }
    public function downloadPage(Request $request,$id){
        $file = File::where('id',$id)->first();
        $arrReturn=[
            'sidebar' =>'file',
            'data'    =>$data,
        ];
        return view($this->view.'download',$arrReturn);
    }
   
}
