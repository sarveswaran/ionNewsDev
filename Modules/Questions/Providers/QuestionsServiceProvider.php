<?php

namespace Modules\Questions\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;

class QuestionsServiceProvider extends ServiceProvider
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
        $this->publishConfig('questions', 'permissions');
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
            'Modules\Questions\Repositories\QuestionsRepository',
            function () {
                $repository = new \Modules\Questions\Repositories\Eloquent\EloquentQuestionsRepository(new \Modules\Questions\Entities\Questions());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Questions\Repositories\Cache\CacheQuestionsDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Questions\Repositories\LikesRepository',
            function () {
                $repository = new \Modules\Questions\Repositories\Eloquent\EloquentLikesRepository(new \Modules\Questions\Entities\Likes());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Questions\Repositories\Cache\CacheLikesDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Questions\Repositories\CommentsRepository',
            function () {
                $repository = new \Modules\Questions\Repositories\Eloquent\EloquentCommentsRepository(new \Modules\Questions\Entities\Comments());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Questions\Repositories\Cache\CacheCommentsDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Questions\Repositories\VoteRepository',
            function () {
                $repository = new \Modules\Questions\Repositories\Eloquent\EloquentVoteRepository(new \Modules\Questions\Entities\Vote());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Questions\Repositories\Cache\CacheVoteDecorator($repository);
            }
        );
// add bindings




    }
}
