<?php

namespace App\Http;

trait ApiResponder{
    protected function array_remove_null($item)
    {
        if(is_null($item))
            return NULL;

        if(method_exists($item, "toArray"))
            $item = $item->toArray();

        if(!is_array($item))
            $item = json_decode(json_encode($item), True);

        if(is_array($item) || is_object($item))
            foreach($item as $key=>$value)
            {
                if(is_object($value))
                {
                    if(method_exists($value, "toArray"))
                        $value = $value->toArray();
                    else
                        $value = (array) $value;
                }

                if(is_array($value))
                {
                    $value = $this->array_remove_null($value);
                    $item[$key] = $value;
                }
                
                if(is_null($value))
                {
                    // choose one, comment the other
                    
                    $item[$key] = "";       // replace null value to empty string
                    // unset($item[$key]);  // remove null value
                }

                if(is_numeric($value))
                {
                    $item[$key] = strval($value);
                }
            }

        return $item;
    }

    protected $responseFormat = [
        'response_code' => NULL,
        'message' => NULL,
        'errors' => [],
        'data' => NULL
    ]; 
    
    protected function success($message = 'Permintaan berhasil diproses.', $data = NULL) {
        return response()->json(array_merge($this->responseFormat, [
            'response_code' => 200,
            'message' => $message,
            'data' => $data,
        ]));
    }

    protected function failure($errors = ['Permintaan gagal diproses.']) {
        return response()->json(array_merge($this->responseFormat, [
            'response_code' => 400,
            'errors' => (is_null($errors) ? $errors : is_array($errors)) ? $errors : [$errors],
        ]));
    }

    protected function unauthorized() {
        return response()->json(array_merge($this->responseFormat, [
            'response_code' => 401,
            'errors' => [
                'Hak akses tidak tersedia.',
            ],
        ]));
    }

    protected function notFound($errors = ['Data tidak ditemukan.']) {
        return response()->json(array_merge($this->responseFormat, [
            'response_code' => 404,
            'errors' => (is_null($errors) ? $errors : is_array($errors)) ? $errors : [$errors],
        ]));
    }

    protected function clientError($errors = ['Client Error Not Found.']) {
        return response()->json(array_merge($this->responseFormat, [
            'response_code' => 405,
            'errors' => (is_null($errors) ? $errors : is_array($errors)) ? $errors : [$errors],
        ]));
    }

    protected function invalidParameters($errors = [])
    {
        return response()->json(array_merge($this->responseFormat, [
            'response_code' => 422,
            'errors' => (is_null($errors) ? $errors : is_array($errors)) ? $errors : [$errors],
        ]));
    }

    protected function customResponse($responseCode = 200, $message = '', $errors = NULL, $data = NULL)
    {
        return response()->json(array_merge($this->responseFormat, [
            'response_code' => $responseCode,
            'message' => $message,
            'errors' => (is_null($errors) ? $errors : is_array($errors)) ? $errors : [$errors],
            'data' => $data,
        ]));
    }

    protected function unauthorizedV2() {
        return response()->json(array_merge($this->responseFormat, [
            'response_code' => 401,
            'errors' => [
                'Hak akses tidak tersedia.',
            ],
        ]));
    }
}