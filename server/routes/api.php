<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->group(function () { //'auth:sanctum'
    Route::controller(GenderController::class)->group(function () {
        Route::post('/novo-genero', 'createGenders');
    });

    Route::controller(PublisherController::class)->group(function () {
        Route::post('/nova-editora', 'createPublisher');
        Route::get('/editoras', 'getPublishers');
    });

    Route::controller(AuthorController::class)->group(function () {
        Route::post('/novo-autor', 'createAuthor');
        Route::get('/autores', 'getAuthors');
    });

    Route::controller(UserController::class)->group(function () {
        Route::post('/novo-usuario', 'createUser');
    });

    Route::controller(BookController::class)->group(function () {
        Route::post('/novo-livro', 'createBook');
        Route::get('/livros', 'getBooks');
    });

    Route::controller(LoanController::class)->group(function () {
        Route::post('/novo-emprestimo', 'createLoan');
        Route::put('/devolve-livros', 'endLoan');
    });
});

Route::get('/teste-api', function () {
    return response()->json(['message' => 'Libary API is working!']);
});


