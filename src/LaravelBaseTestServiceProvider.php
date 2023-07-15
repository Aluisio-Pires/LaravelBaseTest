<?php

namespace AluisioPires\LaravelBaseTest;

use Illuminate\Support\ServiceProvider;

class LaravelBaseTestServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('laravel-base-test', function ($app) {
            $preferredTestClass = config('app.base_test_class', 'BaseTest');

            switch ($preferredTestClass) {
                case 'BaseTestMigrations':
                    return new BaseTestMigrations();
                case 'BaseTestTransactions':
                    return new BaseTestTransactions();
                case 'BaseTestTruncation':
                    return new BaseTestTruncation();
                default:
                    return new BaseTest();
            }
        });
    }
}
