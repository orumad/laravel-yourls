<?php

namespace Orumad\Yourls;

use Illuminate\Support\ServiceProvider;
use Orumad\Yourls\Exceptions\InvalidConfiguration;

class YourlsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/laravel-yourls.php' => config_path('laravel-yourls.php'),
        ], 'laravel-yourls');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/laravel-yourls.php', 'laravel-yourls');

        $yourlsConfig = config('laravel-yourls');

        $this->app->bind(YourlsClient::class, function () use ($yourlsConfig) {
            return new YourlsClient($yourlsConfig['yourls_url'], $yourlsConfig['yourls_api_signature_token']);
        });

        $this->app->bind(Yourls::class, function () use ($yourlsConfig) {
            $this->guardAgainstInvalidConfiguration($yourlsConfig);

            $client = app(YourlsClient::class);

            return new Yourls($client);
        });

        $this->app->alias(Yourls::class, 'laravel-yourls');
    }

    protected function guardAgainstInvalidConfiguration(array $yourlsConfig = null)
    {
        if (empty($yourlsConfig['yourls_url'])) {
            throw InvalidConfiguration::serverUrlNotSpecified();
        }
        if (empty($yourlsConfig['yourls_api_signature_token'])) {
            throw InvalidConfiguration::signatureTokenNotSpecified();
        }
    }
}
