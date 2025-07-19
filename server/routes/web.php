<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [LoginController::class, 'login']);
Route::delete('/logout', [LoginController::class, 'logout']);

Route::get('/obiscoitincsrf', [CsrfCookieController::class, 'show']);

Route::fallback(function () {
    return 'Rota não encontrada.';
});
