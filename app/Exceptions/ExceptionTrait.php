<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use InvalidArgumentException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

trait ExceptionTrait
{
    public function apiException($request, $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return response()->json(['error' => 'Model Not Found'], 404);
        }
        if ($e instanceof RelationNotFoundException) {
            return response()->json(['error' => 'RelationNot Not Found'], 404);
        }
        if ($e instanceof InvalidArgumentException) {
            return response()->json(['error' => 'Invalid Argument'], 400);
        }
        if ($e instanceof AuthenticationException) {
            return response()->json(['error' => 'Authentication'], 401);
        }
        if ($e instanceof RouteNotFoundException) {
            return response()->json(['error' => 'Route Not Found'], 404);
        }
        return response()->json(['error' => 'Not Found'], 404);
    }
}