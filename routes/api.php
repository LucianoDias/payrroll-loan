<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Rotas api  de emprestimos  
Route::get('/institutions',[\App\Http\Controllers\Loan\InstitutionsController::class,'all']);
Route::get('/institutions/{name}',[\App\Http\Controllers\Loan\InstitutionsController::class,'one']);
Route::get('/covenants',[\App\Http\Controllers\Loan\CovenantsController::class, 'all']);
Route::get('/covenants/{name}',[\App\Http\Controllers\Loan\CovenantsController::class,'one']);
Route::post('/simulation',[\App\Http\Controllers\Loan\LoanFeesController::class,'show']);



