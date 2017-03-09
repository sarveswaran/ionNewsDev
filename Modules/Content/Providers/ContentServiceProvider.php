<?php

namespace Modules\Content\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;

class ContentServiceProvider extends ServiceProvider
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
        $this->publishConfig('content', 'permissions');
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
            'Modules\Content\Repositories\ContentRepository',
            function () {
                $repository = new \Modules\Content\Repositories\Eloquent\EloquentContentRepository(new \Modules\Content\Entities\Content());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Content\Repositories\Cache\CacheContentDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Content\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Content\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Content\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Content\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Content\Repositories\ContentImagesRepository',
            function () {
                $repository = new \Modules\Content\Repositories\Eloquent\EloquentContentImagesRepository(new \Modules\Content\Entities\ContentImages());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Content\Repositories\Cache\CacheContentImagesDecorator($repository);
            }
        );
// add bindings



    }
}
