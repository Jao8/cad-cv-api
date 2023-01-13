<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\AuthController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\RoleController;

use function GuzzleHttp\Promise\inspect;

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

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/roles', [RoleController::class, 'list']);

    Route::group(['prefix' => 'cv'], function () {
        Route::post('/insert', [CurriculumController::class, 'insert']);
        Route::put('/update', [CurriculumController::class, 'update']);
        Route::get('/list', [CurriculumController::class, 'list']);
        Route::delete('/delete/{id}', [CurriculumController::class, 'delete']);
        Route::post('/action', [CurriculumController::class, 'action']);
    });
});

Route::post('/login', AuthController::class);

