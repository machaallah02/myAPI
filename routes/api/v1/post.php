<?php

declare(strict_types=1);

use App\Http\Controllers\api\v1\Post\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('posts')
    ->name('posts.')
    ->group(function (): void {
        Route::get('', [PostController::class, 'index'])
            ->name('index');

        Route::get('pagination', [PostController::class, 'pagination'])
            ->name('pagination');

        Route::post('', [PostController::class, 'store'])
            ->name('store');

        Route::get('{id}', [PostController::class, 'show'])
            ->name('show');

        Route::put('{id}', [PostController::class, 'update'])
            ->name('update');

        Route::delete('{id}', [PostController::class, 'destroy'])
            ->name('destroy');
    });
