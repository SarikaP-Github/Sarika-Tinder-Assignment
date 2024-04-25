<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Classes\CustomEncrypt;


class BaseController extends Controller
{

    public function sendResponse($result, $message = '')
    {
        return response()->json($result, 200);
    }

    public function sendError($errorMessage, $code = 500/* , $errors = [] */)
    {
        return response()->json([
            // 'errors' => $errors,
            'message' => $errorMessage,
        ], $code);
    }   

    public function sendValidationError($field, $error, $code = 422, $errorMessages = [])
    {
        $response = [
            'message' => 'Invalid data',
            'errors' => (object) [$field => $error],
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
