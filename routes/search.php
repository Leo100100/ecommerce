<?php

use App\Http\Controllers\SearchController;

Route::get('/search',      [SearchController::class, 'index'])->name('search.index');
Route::get('/search/live', [SearchController::class, 'live'])->name('search.live');
