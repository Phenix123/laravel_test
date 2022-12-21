<?php

use App\Http\Controllers\Api\CarApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// READ
Route::get('/cars', [CarApiController::class, 'index'])->name('cars.index');
Route::get('/cars/{car}', [CarApiController::class, 'show'])->name('cars.show');
// CREATE
Route::post('/cars', [CarApiController::class, 'store'])->name('cars.store');
// UPDATE
Route::patch('/cars/{car}', [CarApiController::class, 'update'])->name('cars.update');
//DELETE
Route::delete('/cars/delete/{car}', [CarApiController::class, 'delete'])->name('cars.delete');
