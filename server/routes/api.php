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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/novo-genero', [GenderController::class, 'createGenders']);

    Route::post('/nova-editora', [PublisherController::class, 'createPublisher']);
    Route::get('/editoras', [PublisherController::class, 'getPublishers']);

    Route::post('/novo-autor', [AuthorController::class, 'createAuthor']);
    Route::get('/autores', [AuthorController::class, 'getAuthors']);

    Route::post('/novo-usuario', [UserController::class, 'createUser']);

    Route::post('/novo-livro', [BookController::class, 'createBook']);
    Route::get('/livros', [BookController::class, 'getBooks']);

    Route::post('/novo-emprestimo', [LoanController::class, 'createLoan']);
    Route::put('/devolve-livros', [LoanController::class, 'endLoan']);
});

Route::get('/teste-api', function () {
    return response()->json(['message' => 'Libary API is working!']);
});


