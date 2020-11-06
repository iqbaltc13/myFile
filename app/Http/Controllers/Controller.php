<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\ApiResponder;
use Illuminate\Http\Request;
use Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ApiResponder,  ValidatesRequests;
    protected function customValidation(Request $request, $rules = [], $messages = [])
    {
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->invalidParameters($validator->errors()->all());
        } else {
            return TRUE;
        }
    }

    protected function guardWithValidation(Request $request, $rules = [], $messages = [], $callback)
    {
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->invalidParameters($validator->errors()->all());
        } else {
            return $callback();
        }
    }
    public function rupiah($angka){
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah;
    }
}
