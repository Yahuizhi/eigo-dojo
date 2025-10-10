<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Question;
use App\Policies\QuestionPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Question::class => QuestionPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
        Gate::policy(Question::class, QuestionPolicy::class);

    //     // Gate::define('delete', function ($user, $question) {
    //     // // 認可のロジック
    //     // return $user->id === $question->user_id;
    // });
    }
}
