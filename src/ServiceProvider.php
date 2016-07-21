<?php

namespace Topix\Hackademy\ContactToolSdk;


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
