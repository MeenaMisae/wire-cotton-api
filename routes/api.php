<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\Category\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum']);

Route::prefix('products')->group(static function () {
    Route::get('categories', [CategoryController::class, 'index']);
});
