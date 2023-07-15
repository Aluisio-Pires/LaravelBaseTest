<?php

namespace AluisioPires\LaravelBaseTest;

use Illuminate\Support\ServiceProvider;

class LaravelBaseTestServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('meu-package', function ($app) {
            return new BaseTest();
        });
    }
}
