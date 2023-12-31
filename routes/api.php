<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AhorroController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('ahorros', AhorroController::class);
Route::post('ahorros/actualizar-resultado-acumulado', [AhorroController::class, 'actualizarResultadoAcumulado']);

Route::post('ahorros/actualizar-resultado-acumulado/{id}', [AhorroController::class, 'actualizarResultadoAcumuladoUno']);

