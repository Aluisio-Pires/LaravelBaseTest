<?php

namespace AluisioPires\LaravelBaseTest;

use Illuminate\Support\ServiceProvider;

class LaravelBaseTestServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('laravel-base-test', function ($app) {
            $traits = (Array) config('app.base_test_traits', []);
            return new BaseTest($traits);
        });
    }
}
