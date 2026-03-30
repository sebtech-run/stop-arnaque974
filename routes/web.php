<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicScamController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

// Page d'accueil : Liste des arnaques
Route::get('/', [PublicScamController::class, 'index'])->name('home');

// Page de signalement
Route::get('/signaler', [PublicScamController::class, 'create'])->name('scam.create');
Route::post('/signaler', [PublicScamController::class, 'store'])->name('scam.store');

// Page de détail d'une arnaque (On utilise {scam} pour que Laravel retrouve l'ID tout seul)
Route::get('/arnaque/{scam}', [PublicScamController::class, 'show'])->name('scam.show');




Route::get('/prevention', [PostController::class, 'index'])->name('posts.index');
Route::get('/prevention/{slug}', [PostController::class, 'show'])->name('posts.show');


Route::get('/mentions-legales', [PageController::class, 'legal'])->name('pages.legal');
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');


Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');

// Liste complète des arnaques
Route::get('/les-arnaques', [PublicScamController::class, 'indexAll'])->name('scams.index');
