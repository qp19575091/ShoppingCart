<?php

namespace App\Exceptions;

use Exception;
use Doctrine\DBAL\Exception\DatabaseObjectExistsException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use InvalidArgumentException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class CustomException extends Exception
{
   
    public function apiException($request, $e)
    {
        if ($this->isModel($e)) {
            return response()->json(['error' => 'Model Not Found'], 404);
        }
        if ($this->isRelation($e)) {
            return response()->json(['error' => 'RelationNot Not Found'], 404);
        }
        if ($this->isInvalidArgument($e)) {
            return response()->json(['error' => 'Invalid Argument'], 400);
        }
        if ($this->isAuthentication($e)) {
            return response()->json(['error' => 'Unauthentication'], 401);
        }
        if ($this->isRoute($e)) {
            return response()->json(['error' => 'Route Not Found'], 404);
        }
        if ($e instanceof DatabaseObjectExistsException) {
            return response()->json(['error' => 'Data has been exist'], 400);
        }
       
        //return response()->json(['error' => 'Server Error'], 500);
    }

    //Check the resource is exist
    public function isModel($e)
    {
        return $e instanceof ModelNotFoundException;
    }

    //Check the relation is exist
    public function isRelation($e)
    {
        return $e instanceof RelationNotFoundException;
    }

    //Check the argument is vaild
    public function isInvalidArgument($e)
    {
        return $e instanceof InvalidArgumentException;
    }

    //Check the Authentication
    public function isAuthentication($e)
    {
        return $e instanceof AuthenticationException;
    }

    //Check the route exist
    public function isRoute($e)
    {
        return $e instanceof RouteNotFoundException;
    }
}

