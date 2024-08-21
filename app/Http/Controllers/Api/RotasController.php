<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RotasRepository;

class RotasController extends Controller{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $rotasRepositorio;
    public function __construct(RotasRepository $rotasRepositorio)
    {
        $this->rotasRepositorio = $rotasRepositorio;
        
    }
    public function rotas(Request $request) {
        try {
            $saida= $this->rotasRepositorio->rotas($request);
            return $this->responseSuccessJson($saida);
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->responseExceptionJson($e);
        } catch (\Exception $exception) {
            return $this->responseExceptionJson($exception);
        }

    }
    public function simular(Request $request) {
        try {
            $saida= $this->rotasRepositorio->simular($request);
            return $this->responseSuccessJson($saida);
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->responseExceptionJson($e);
        } catch (\Exception $exception) {
            return $this->responseExceptionJson($exception);
        }

    }
    public function cotacao(Request $request) {
        try {
            $saida= $this->rotasRepositorio->cotacaoServico($request);
            return $this->responseSuccessJson($saida);
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->responseExceptionJson($e);
        } catch (\Exception $exception) {
            return $this->responseExceptionJson($exception);
        }

    }
    public function criptografia(Request $request) {
        try {
            $saida= $this->rotasRepositorio->criptografia($request);
            return $this->responseSuccessJson($saida);
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->responseExceptionJson($e);
        } catch (\Exception $exception) {
            return $this->responseExceptionJson($exception);
        }
    }
    public function buscarDadosUsuario(Request $request) {
        try {
            $saida= $this->rotasRepositorio->buscarDadosUsuario($request);
            return $this->responseSuccessJson($saida);
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->responseExceptionJson($e);
        } catch (\Exception $exception) {
            return $this->responseExceptionJson($exception);
        }
    }
    public function buscarEnderecoCoordenada(Request $request) {
        try {
            $saida= $this->rotasRepositorio->buscarEnderecoCoordenada($request);
            return $this->responseSuccessJson($saida);
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->responseExceptionJson($e);
        } catch (\Exception $exception) {
            return $this->responseExceptionJson($exception);
        }
    }
    public function autocomplete(Request $request) {
        try {
            $saida= $this->rotasRepositorio->autocomplete($request);
            return $saida;
        } catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->responseExceptionJson($e);
        } catch (\Exception $exception) {
            return $this->responseExceptionJson($exception);
        }
    }
}