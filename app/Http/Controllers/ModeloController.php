<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModeloController extends Controller{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        
    }
    public function modeloBasico(Request $request) {
        try {
            $saida="";
            return $this->responseSuccessJson($saida);
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->responseExceptionJson($e);
        } catch (\Exception $exception) {
            return $this->responseExceptionJson($exception);
        }

    }
}