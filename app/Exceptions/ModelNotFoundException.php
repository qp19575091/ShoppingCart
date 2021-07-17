<?php

namespace App\Exceptions;

class ModelNotFoundException extends CustomException
{
    public function __construct()
    {
        parent::__construct(new \Exception('Resource Not Found'));
    }

    public function render($request) {
        return response('testse');
    }
}
// class CustomerError {
//     private error

//     CustomerError(error: Exception) {
//         this.erro = error;
//    }

//    toString() {
//        this.error.toString()
//    }
// }


// class NotFoundHttpException  extends CustomerError {
//     constructor(message: string) {
//         super(message + ' Not Found')
//     }
// }

// NotFoundHttpException.toString();