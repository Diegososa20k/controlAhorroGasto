<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('welcome'); // Utiliza 'welcome' si ese es el nombre de tu vista principal
})->where('any', '.*');
