<?php

namespace App\Helpers;

class CustomJsonResponse{
    private function respond($success = true, $message = null, $errors = [], $data = null){
        return \response()->json([
            'success' => $success,
            'message' => $message,
            'errors' => $errors,
            'data' => $data,
        ]);
    }

    function success($message = null){
        return $this->respond(true, $message);
    }

    function error($error = null, $data = null){
        return $this->respond(false, $error, [], $data);
    }

    function errors($errors, $data = null){
        return $this->respond(false, null, $errors, $data);
    }

    function data($data, $message = null){
        return $this->respond(true, $message, [], $data);
    }
}
