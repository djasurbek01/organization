<?php

use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ActivityController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::prefix('organizations')->group(function () {
    Route::get('/building/{id}', [OrganizationController::class, 'byBuilding']);
    Route::get('/activity/{id}', [OrganizationController::class, 'byActivity']);
    Route::get('/search', [OrganizationController::class, 'searchByName']);
    Route::get('/location', [OrganizationController::class, 'byLocation']);
    Route::get('/{id}', [OrganizationController::class, 'show']);
});

Route::get('/buildings', [BuildingController::class, 'index']);
Route::get('/buildings/{id}', [BuildingController::class, 'show']);

Route::get('/activities', [ActivityController::class, 'index']);
Route::get('/activities/{id}', [ActivityController::class, 'show']);