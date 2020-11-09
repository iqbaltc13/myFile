<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;

class DirectoryController extends Controller
{
    public function create($path){
        $result = File::makeDirectory($path);
        return $result;
    }
}
