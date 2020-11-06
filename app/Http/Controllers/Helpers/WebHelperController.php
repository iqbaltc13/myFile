<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebHelperController extends Controller
{
    
    public function __construct()
    {
        $this->view_error='errors.';
    }
    public function error404(Request $request, $arrParse=[]){
        return view($this->view_error.'404error',$arrParse);
    }
    public function error500(Request $request, $arrParse=[]){
        return view($this->view_error.'500error',$arrParse);
    }
}
