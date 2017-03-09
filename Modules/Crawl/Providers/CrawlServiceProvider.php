<?php

namespace Modules\Crawl\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;

class CrawlServiceProvider extends ServiceProvider
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
        $this->publishConfig('crawl', 'permissions');
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
            'Modules\Crawl\Repositories\CrawlContentRepository',
            function () {
                $repository = new \Modules\Crawl\Repositories\Eloquent\EloquentCrawlContentRepository(new \Modules\Crawl\Entities\CrawlContent());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Crawl\Repositories\Cache\CacheCrawlContentDecorator($repository);
            }
        );
// add bindings

    }
}
