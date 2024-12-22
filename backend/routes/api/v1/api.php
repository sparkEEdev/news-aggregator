<?php

use App\Core\v1\Category\Controllers\CategoryController;
use App\Core\v1\Source\Controllers\SourceController;
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


require __DIR__ . '/auth.php';
require __DIR__ . '/public.php';

Route::middleware(['auth:sanctum'])->group(function () {
    require __DIR__ . '/dashboard.php';

    Route::resource('categories', CategoryController::class)->only(['index']);
    Route::resource('sources', SourceController::class)->only(['index']);
});
