<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Answer;
use App\Observers\AnswerObserver;
use App\Question;
use App\Observers\QuestionObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Question::observe(QuestionObserver::class);
        Answer::observe(AnswerObserver::class);
    }
}
