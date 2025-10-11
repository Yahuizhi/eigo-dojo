<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StoredQuestionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PriorityController;

Route::get('/', function () {
    return view('welcome');
});

// 認証済みで verified なユーザーのみアクセス可能
Route::get('/home', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 認証が必要なルートグループ
Route::middleware('auth')->group(function () {
    
    // =======================================================
    // 1. 全ユーザー（テストアカウント含む）が利用できるルート (読み取り/回答投稿)
    // =======================================================
    
    // QuestionController (質問の閲覧と回答)
    Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');

    // ★★★ 修正点: user-posts (静的URI) を動的URIよりも先に定義する ★★★
    Route::get('/questions/user-posts', [QuestionController::class, 'user_posts'])->name('questions.user_posts');
    
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');
    
    // edit ルート（showより後に定義するのはOK）
    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    
    // 回答投稿 (store)
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
    
    // 検索
    Route::get('search', [SearchController::class, 'index'])->name('search');
    
    // StoredQuestion (質問マスタの読み取り)
    Route::get('/stored_questions', [StoredQuestionController::class, 'index'])->name('stored_questions.index');
    Route::get('/stored_questions/{stored_question}', [StoredQuestionController::class, 'show'])->name('stored_questions.show');

    // Profile の閲覧
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');


    // =======================================================
    // 2. テストアカウントの書き込みを制限するルート (prevent-test-writeで保護)
    // =======================================================
    
    Route::middleware('prevent-test-write')->group(function () {
        
        // QuestionController の更新と削除 (update, destroy)
        Route::patch('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
        Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

        // StoredQuestionController の書き込み系 (create/edit は通常不要なので store, update, destroy のみ)
        Route::post('/stored_questions', [StoredQuestionController::class, 'store'])->name('stored_questions.store');
        Route::patch('/stored_questions/{stored_question}', [StoredQuestionController::class, 'update'])->name('stored_questions.update');
        Route::delete('/stored_questions/{stored_question}', [StoredQuestionController::class, 'destroy'])->name('stored_questions.destroy');
        
        // 優先度の更新
        Route::post('/priority', [PriorityController::class, 'priority_update'])->name('priority.update');
        
        // Profile の更新と削除 
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';