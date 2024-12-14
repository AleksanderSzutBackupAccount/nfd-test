<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure\Providers;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Src\Shared\Domain\Bus\CommandInterface;

abstract class BaseContextServiceProvider extends ServiceProvider
{
    /**
     * @var array<int, class-string>
     */
    protected array $providers = [];

    /**
     * @var array<class-string, class-string>
     */
    protected array $binds = [];

    /**
     * @var array<class-string<CommandInterface>, class-string>
     */
    protected array $useCases = [];

    /**
     * @var array<string,string>
     */
    protected array $routeBinds = [];

    /**
     * @var array<string,string>
     */
    protected array $policies = [];

    /**
     * @var array<int, string>
     */
    protected array $commands = [];

    /**
     * @return void
     */
    public function register(): void
    {
        $this->registerProviders();
        $this->registerCommands();
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->bootBinds();
        $this->bootUseCases();
        $this->bootRouteBinds();
        $this->bootPolicies();
    }

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function bootPolicies(): void
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * @return void
     */
    protected function registerProviders(): void
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * @return void
     */
    protected function bootBinds(): void
    {
        foreach ($this->binds as $key => $bind) {
            $this->app->bind($key, $bind);
        }
    }

    /**
     * @return void
     */
    protected function bootUseCases(): void
    {
        /** @var Dispatcher $dispatcher */
        $dispatcher = app(Dispatcher::class);
        $dispatcher->map($this->useCases);
    }

    /**
     * @return void
     */
    protected function bootRouteBinds(): void
    {
        foreach ($this->routeBinds as $key => $bind) {
            Route::model($key, $bind);
        }
    }

    /**
     * @return void
     */
    protected function registerCommands(): void
    {
        $this->commands($this->commands);
    }
}
