<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\Models\File;
use App\User;
use Hash;
use File as Files;

use Carbon\Carbon;
use \Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;
use Validator;
use DB;
use App\Http\EncapsulatedApiResponder;
use App\Models\ConfirmationUser;
use Mail;
use Illuminate\Support\Str;
use App\Models\Business;
use App\Models\Employee;
use App\Models\UserRecord;
use App\Models\UserWithToken;
use App\Http\Controllers\Helpers\DirectoryController;
use ZipArchive;
        


class FileController extends Controller
{
    public function __construct()
    {
        $this->route            = 'dashboard.file.';
        $this->view             = 'dashboard.file.';
        $this->directory_helper = new DirectoryController();
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
        $zipFile = new \PhpZip\ZipFile();
        $zipFile->openFile($request->file('file'));
        
        $start = microtime(true);	
        
        $user 			   = $request->user();
        
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
       
        
        $file->name        = $user->id.'_'.$file_name.'_'.$request->name.'.'.$ext;
        $file->full_path   = $full_path;
        $file->path        = $path.$file_name;
        
        $file->user_id 	   = $user->id;
        $file->save();

        $createExtractFolder= public_path('/uploads/zip/'.$file->id);
        $this->directory_helper->create($createExtractFolder);
        $zipFile->extractTo(public_path('/uploads/zip/'.$file->id));
        
        DB::commit();
      
        return redirect()->route($this->route.'download-page',['id' => $file->id])
        ->with('success', 'Sukses menambah file');
        
    }
    public function download(Request $request,$id){
        $file = File::where('id',$id)->first();
        if($file){
            $filePath = $file->full_path;
            if (Auth::id() == $file->user_id){
                return redirect()->to($filePath);
            }
            else{
                return redirect()->route($this->route.'index')
                ->with('error', 'Anda tidak punya akses untuk file ini');
            }
           
          
        }
        return redirect()->route($this->route.'index')
        ->with('error', 'File Tidak ditemukan');
       
       
    }
    public function download2(Request $request,$id){
        $file = File::where('id',$id)->first();
        
        if($file){
            $filePath = $file->full_path;
            if (Auth::id() == $file->user_id){
                $fileFromFolder = scandir(public_path('/uploads/zip/'.$file->id));
                unset($fileFromFolder[0], $fileFromFolder[1]);
                $zipFile = new \PhpZip\ZipFile();
                
                $zipFile->setCompressionLevel(\PhpZip\Constants\ZipCompressionLevel::MAXIMUM);
                
                //return $zipFile->outputAsAttachment('download'.$file->name,'application/zip');
                $zip = new ZipArchive;
   
                $fileName = 'download.zip';
           
                if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
                {
                    $getFiles = Files::files(public_path('/uploads/zip/'.$file->id));
           
                    foreach ($getFiles as $key => $value) {
                        $relativeNameInZipFile = basename($value);
                        $zip->addFile($value, $relativeNameInZipFile);
                    }
                     
                    $zip->close();
                }
                dd($zip);
            
                return response()->download(public_path($fileName));
                
            }
            else{
                return redirect()->route($this->route.'index')
                ->with('error', 'Anda tidak punya akses untuk file ini');
            }
           
          
        }
        return redirect()->route($this->route.'index')
        ->with('error', 'File Tidak ditemukan');

       
    }
    public function downloadPage(Request $request,$id){
        $data = File::where('id',$id)->first();
        $arrReturn=[
            'sidebar' =>'file',
            'data'    =>$data,
        ];
        return view($this->view.'download',$arrReturn);
    }
   
}
