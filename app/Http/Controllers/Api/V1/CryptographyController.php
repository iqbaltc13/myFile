<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use Hash;

class CryptographyController extends ApiController{
    public function encrypt(Request $request){
        return $this->success('Berhasil',[
            'cipher_text' => $this->encryptString($request->plain_text)
        ]);
    }
    public function decrypt(Request $request){
        $decrypted = $this->decryptString($request->cipher_text);
        if ($decrypted=="") {
            return $this->failure('Gagal');
        }else{
            return $this->success('Berhasil',[
                'text' => $decrypted
            ]);
        }
    }

    public function test(Request $request){
        $decrypted      = $this->decryptString($request->data);
        return $decrypted;
    }
}
