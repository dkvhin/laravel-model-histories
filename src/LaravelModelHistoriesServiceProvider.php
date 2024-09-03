<?php

namespace Dkvhin\LaravelModelHistories;
use Illuminate\Support\ServiceProvider;

class LaravelModelHistoriesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/model_histories.php' => config_path('model_histories.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../database/create_model_has_histories_table.php.stub' => database_path('migrations/2024_09_03_222954_create_system_model_has_histories_table.php'),
            ], 'migrations');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/model_histories.php', 'model_histories');
    }
}
