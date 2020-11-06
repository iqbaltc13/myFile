<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Http\Controllers\Api\ApiController;
use App\Models\User;
use Hash;

class ExampleController extends ApiController{
    public function one(Request $request){
        return $this->success('Berhasil',[
            'text' => "Halo"
        ]);
    }
}