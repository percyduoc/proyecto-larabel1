<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuentaController;



Route::get('/{any}', function () {
    return view('home');
})->where('any', '^(?!api).*$');

