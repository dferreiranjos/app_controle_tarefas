<?php

use App\Http\Controllers\TarefaController;
use App\Mail\MensagemTesteEmail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify'=>true]);

// Retirei essa rota pois alterei a rota principal para tarefa em RouteServiceProviders.php
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
//     ->name('home')
//     ->middleware('verified');

Route::resource('tarefa', TarefaController::class)
    ->middleware('verified');

Route::get('mensagem-teste', function(){
    return new MensagemTesteEmail();
    // Mail::to('dferreiranjos@yahoo.com.br')->send(new MensagemTesteEmail());
    // return 'Mensagem enviada com sucesso!';
});
