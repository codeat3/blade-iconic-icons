<?php

declare(strict_types=1);

namespace Codeat3\BladeIconicIcons;

use BladeUI\Icons\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;

final class BladeIconicIconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-iconic-icons', []);

            $factory->add('iconic', array_merge(['path' => __DIR__.'/../resources/svg'], $config));
        });

    }

    private function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-iconic-icons.php', 'blade-iconic-icons');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/svg' => public_path('vendor/blade-iconic-icons'),
            ], 'blade-iconic-icons');

            $this->publishes([
                __DIR__.'/../config/blade-iconic-icons.php' => $this->app->configPath('blade-iconic-icons.php'),
            ], 'blade-iconic-icons-config');
        }
    }

}
