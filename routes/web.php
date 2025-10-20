<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StoredQuestionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PriorityController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/home', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {    
    
    Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store'); 
    Route::get('/questions/user-posts', [QuestionController::class, 'user_posts'])->name('questions.user_posts');
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');
    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
     
    
    Route::get('search', [SearchController::class, 'index'])->name('search');
        
    Route::get('/stored_questions', [StoredQuestionController::class, 'index'])->name('stored_questions.index');
    Route::get('/stored_questions/{stored_question}', [StoredQuestionController::class, 'show'])->name('stored_questions.show');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
    Route::post('/priority', [PriorityController::class, 'priority_update'])->name('priority.update');


    Route::middleware('prevent-test-write')->group(function () {
                
        
        Route::patch('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
        Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

        
        Route::post('/stored_questions', [StoredQuestionController::class, 'store'])->name('stored_questions.store');
        Route::patch('/stored_questions/{stored_question}', [StoredQuestionController::class, 'update'])->name('stored_questions.update');
        Route::delete('/stored_questions/{stored_question}', [StoredQuestionController::class, 'destroy'])->name('stored_questions.destroy');
                
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';
