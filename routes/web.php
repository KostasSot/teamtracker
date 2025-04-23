<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('app'); // this is app.blade.php
})->where('any', '.*');
