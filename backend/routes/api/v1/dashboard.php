<?php

use App\Core\v1\Dashboard\Controllers\TourController;
use App\Core\v1\Dashboard\Controllers\TravelController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'dashboard',
    'middleware' => 'role:admin',
], function () {

});

