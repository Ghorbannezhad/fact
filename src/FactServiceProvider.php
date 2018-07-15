<?php

namespace Ghorbannezhad\Fact;

use Illuminate\Support\ServiceProvider;

class FactServiceProvider extends ServiceProvider {

    public function boot(){

        include __DIR__.'/routes.php';
        $this->publishes([__DIR__.'/../config/fact.php'=>config_path('fact.php'),'config']);
    }

    public function register(){
        $this->loadViewsFrom(__DIR__.'/views','fact');
        $this->mergeConfigFrom(__DIR__ . '/../config/fact.php','fact');

        $this->app->make('Ghorbannezhad\Fact\FactController');

        // Ajax Facade
        $this->app->bind('fact', function($app) {
            return new FactController();
        });
    }

}