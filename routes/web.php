<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversaoController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/', [ConversaoController::class, 'index'])->name('index');
// Route::post('/converter', [ConversaoController::class, 'converterRomanoDecimal'])->name('converter');
Route::post('/converter', [ConversaoController::class, 'verificarConversao'])->name('converter');

Route::get('/historico', [ConversaoController::class, 'historico'])->name('historico');


