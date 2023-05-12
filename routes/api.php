<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\HomePageController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\AuthorBooksController;
use App\Http\Controllers\Api\MangeAuthorController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/user-registration', [AuthController::class, 'userRegistration'])->name('api.user.register');
Route::get('/list-books', [HomePageController::class, 'listBooks'])->name('api.books.list');


Route::name('api.')
    ->middleware('auth:api')
    ->group(function () {
        Route::apiResource('authors', AuthorController::class);
        // Author Books
        Route::get('/authors/{author}/books', [
            AuthorBooksController::class,
            'index',
        ])->name('authors.books.index');
        Route::post('/authors/{author}/books', [
            AuthorBooksController::class,
            'store',
        ])->name('authors.books.store');

        Route::apiResource('books', BookController::class);
        Route::apiResource('users', UserController::class);
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::post('/change-author-status/{id}', [
            MangeAuthorController::class,
            'changeAuthorStatus',
        ])->name('authors.change-status');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
