<?php

use Illuminate\Support\Facades\Route;
use App\Core\v1\Source\Controllers\SourceController;
use App\Core\v1\Article\Controllers\ArticleController;
use App\Core\v1\Category\Controllers\CategoryController;

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
    Route::resource('articles', ArticleController::class)->only(['index', 'show']);
});
