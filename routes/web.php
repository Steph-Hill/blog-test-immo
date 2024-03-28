<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/mes-articles',[ArticleController::class,'index'])->name('list-articles');

/* route pour conserver les pages des composants vue*/
Route::get('/{any}', function () {
    return view('articles.articles'); 
})->where('any', '.*');