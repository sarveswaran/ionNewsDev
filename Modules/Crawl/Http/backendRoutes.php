<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/crawl'], function (Router $router) {
    $router->bind('crawlcontent', function ($id) {
        return app('Modules\Crawl\Repositories\CrawlContentRepository')->find($id);
    });
    $router->get('crawlcontents', [
        'as' => 'admin.crawl.crawlcontent.index',
        'uses' => 'CrawlContentController@index',
        'middleware' => 'can:crawl.crawlcontents.index'
    ]);
    $router->get('crawlcontents/create', [
        'as' => 'admin.crawl.crawlcontent.create',
        'uses' => 'CrawlContentController@create',
        'middleware' => 'can:crawl.crawlcontents.create'
    ]);
    $router->post('crawlcontents', [
        'as' => 'admin.crawl.crawlcontent.store',
        'uses' => 'CrawlContentController@store',
        'middleware' => 'can:crawl.crawlcontents.create'
    ]);
    $router->get('crawlcontents/{crawlcontent}/edit', [
        'as' => 'admin.crawl.crawlcontent.edit',
        'uses' => 'CrawlContentController@edit',
        'middleware' => 'can:crawl.crawlcontents.edit'
    ]);
    $router->put('crawlcontents/{crawlcontent}', [
        'as' => 'admin.crawl.crawlcontent.update',
        'uses' => 'CrawlContentController@update',
        'middleware' => 'can:crawl.crawlcontents.edit'
    ]);
    $router->delete('crawlcontents/{crawlcontent}', [
        'as' => 'admin.crawl.crawlcontent.destroy',
        'uses' => 'CrawlContentController@destroy',
        'middleware' => 'can:crawl.crawlcontents.destroy'
    ]);
// append

});
