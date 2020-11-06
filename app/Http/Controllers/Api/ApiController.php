<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\EncapsulatedApiResponder;
use Validator;

class ApiController extends Controller
{
    use EncapsulatedApiResponder;

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
}
