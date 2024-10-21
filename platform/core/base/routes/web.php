<?php

use Illuminate\Support\Facades\Route;

Route::get('/core-base', function () {
    return view('core_base::index');
})->name('core_base.index');