<?php

namespace Modules\Testinomials\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;

class TestinomialsServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    public function boot()
    {
        $this->publishConfig('testinomials', 'permissions');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Testinomials\Repositories\TestinomialsRepository',
            function () {
                $repository = new \Modules\Testinomials\Repositories\Eloquent\EloquentTestinomialsRepository(new \Modules\Testinomials\Entities\Testinomials());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Testinomials\Repositories\Cache\CacheTestinomialsDecorator($repository);
            }
        );
// add bindings

    }
}
