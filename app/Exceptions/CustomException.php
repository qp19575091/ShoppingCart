<?php

class CustomException
{
    private $error;

    public function __construct(Exception $error)
    {
        $this->error = $error;
    }

    public function toJson()
    {
        return response()->json(['error' => $this->error]);
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