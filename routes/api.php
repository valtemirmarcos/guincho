<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RotasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['prefix' => 'localizacao'], function(){
    // Route::get('/rotas', [RotasController::class, 'rotas'])->name('rotas');
    Route::post('/rotas', [RotasController::class, 'rotas'])->name('rotas');
    Route::post('/cotacao', [RotasController::class, 'cotacao'])->name('cotacao');
    Route::post('/buscarEnderecoCoordenada', [RotasController::class, 'buscarEnderecoCoordenada'])->name('buscarEnderecoCoordenada');
    Route::get('/autocomplete', [RotasController::class, 'autocomplete'])->name('autocomplete');
});
Route::group(['prefix' => 'admin'], function(){
    Route::post('/criptografia', [RotasController::class, 'criptografia'])->name('criptografia');
    Route::get('/buscarDadosUsuario', [RotasController::class, 'buscarDadosUsuario'])->name('buscarDadosUsuario');
});

Route::get('/teste', function () {
    return phpInfo();
});