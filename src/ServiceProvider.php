<?php

namespace Topix\Hackademy\ContactToolSdk;

use Illuminate\Database\Eloquent\Relations\Relation;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/anagrafica.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');
        $this->publishes([__DIR__.'/../database/migrations/' => database_path('migrations')], 'migrations');
        
        // Define Custom Polymorphic Types
        Relation::morphMap([

        ]);

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/anagrafica.php';
        $this->mergeConfigFrom($configPath, 'anagrafica');
    }

    protected function getConfigPath()
    {
        return config_path('anagrafica.php');
    }
}
