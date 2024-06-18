<?php

use App\Http\Controllers\Product\Attribute\AttributeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\Category\CategoryController;
use App\Http\Controllers\Product\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum']);

Route::prefix('products')->group(static function () {
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('attributes/{categoryId}', [AttributeController::class, 'getCategoryAttributes']);
    Route::post('', [ProductController::class, 'store']);
});
