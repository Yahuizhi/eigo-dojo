<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StoredQuestionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PriorityController;


Route::get('/', function () {
    return view('top');
});

Route::get('/top', function () {
    return view('top');
})->middleware(['auth', 'verified'])->name('top');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/questions/user-posts', [QuestionController::class, 'user_posts'])->name('questions.user_posts');

Route::resource('questions',QuestionController::class)
        ->middleware(['auth','verified']);

Route::resource('stored_questions',StoredQuestionController::class)
        ->middleware(['auth', 'verified']);
        
Route::get('search',[SearchController::class, 'index'])->middleware('auth')->name('search');

Route::post('/priority',[PriorityController::class,'priority_update'])->name('priority.update');

require __DIR__.'/auth.php';
