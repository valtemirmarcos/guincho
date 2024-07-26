<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function responseSuccessJson($data = null, $message = null)
    {
        $result['status'] = 'success';

        if($message){
            $result['message'] = $message;
        }
        
        if($data){
            $result['data'] = $data;
        }

        return response()->json($result, 200);
    }

    public function responseExceptionJson($exception)
    {
        return response()->json([
            'status' => "exception",
            'message' => $exception->getCode()." - ".$exception->getMessage()
        ],200);
    }

    public function responseErrorJson($message, $code, $data = null)
    {
        $result['status'] = 'error';

        $result['message'] = $message;

        if($data){
            $result['data'] = $data;
        }

        return response()->json($result, $code);
    }

    public function exibeQuery($query)
    {
        $sql = $query->toSql();
        $bindings = $query->getBindings();

        foreach($bindings as $binding)
        {
            $value = is_numeric($binding) ? $binding : "'".$binding."'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        
        return $sql;
    }
}
