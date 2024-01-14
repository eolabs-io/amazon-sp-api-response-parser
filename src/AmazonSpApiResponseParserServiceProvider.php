<?php

namespace EolabsIo\AmazonSpApiResponseParser;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use EolabsIo\AmazonSpApiResponseParser\AmazonSpApiResponseParser;
use EolabsIo\AmazonSpApiResponseParser\Parsers\ReviewResponseParser;
use EolabsIo\AmazonSpApiResponseParser\Parsers\ReviewRatingResponseParser;
use EolabsIo\AmazonSpApiResponseParser\Parsers\GetReportResponseParser;

class AmazonSpApiResponseParserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'amazon-sp-api-response-parser');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'amazon-sp-api-response-parser');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('amazon-sp-api-response-parser.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/amazon-sp-api-response-parser'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/amazon-sp-api-response-parser'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/amazon-sp-api-response-parser'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);

            Collection::macro('recursive', function () {
                return $this->map(function ($value) {
                    if (is_array($value) || is_object($value)) {
                        return collect($value)->recursive();
                    }

                    return $value;
                });
            });
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'amazon-sp-api-response-parser');

        // Register the main class to use with the facade
        $this->app->singleton('amazon-sp-api-response-parser', function () {
            return new AmazonSpApiResponseParser;
        });

        $this->app->singleton('amazon-review-rating-response-parser', function () {
            return new ReviewRatingResponseParser;
        });

        $this->app->singleton('amazon-review-response-parser', function () {
            return new ReviewResponseParser;
        });

        $this->app->singleton('amazon-get-report-response-parser', function () {
            return new GetReportResponseParser;
        });
    }
}
