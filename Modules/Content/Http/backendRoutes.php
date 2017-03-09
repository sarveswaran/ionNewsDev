<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/content'], function (Router $router) {
    $router->bind('content', function ($id) {
        return app('Modules\Content\Repositories\ContentRepository')->find($id);
    });
    $router->get('contents', [
        'as' => 'admin.content.content.index',
        'uses' => 'ContentController@index',
        'middleware' => 'can:content.contents.index'
    ]);
    $router->get('contents/create', [
        'as' => 'admin.content.content.create',
        'uses' => 'ContentController@create',
        'middleware' => 'can:content.contents.create'
    ]);
    $router->post('contents', [
        'as' => 'admin.content.content.store',
        'uses' => 'ContentController@store',
        'middleware' => 'can:content.contents.create'
    ]);
    $router->get('contents/{content}/edit', [
        'as' => 'admin.content.content.edit',
        'uses' => 'ContentController@edit',
        'middleware' => 'can:content.contents.edit'
    ]);
    $router->put('contents/{content}', [
        'as' => 'admin.content.content.update',
        'uses' => 'ContentController@update',
        'middleware' => 'can:content.contents.edit'
    ]);
    $router->delete('contents/{content}', [
        'as' => 'admin.content.content.destroy',
        'uses' => 'ContentController@destroy',
        'middleware' => 'can:content.contents.destroy'
    ]);
    $router->bind('category', function ($id) {
        return app('Modules\Content\Repositories\CategoryRepository')->find($id);
    });
    $router->get('categories', [
        'as' => 'admin.content.category.index',
        'uses' => 'CategoryController@index',
        'middleware' => 'can:content.categories.index'
    ]);
    $router->get('categories/create', [
        'as' => 'admin.content.category.create',
        'uses' => 'CategoryController@create',
        'middleware' => 'can:content.categories.create'
    ]);
    $router->post('categories', [
        'as' => 'admin.content.category.store',
        'uses' => 'CategoryController@store',
        'middleware' => 'can:content.categories.create'
    ]);
    $router->get('categories/{category}/edit', [
        'as' => 'admin.content.category.edit',
        'uses' => 'CategoryController@edit',
        'middleware' => 'can:content.categories.edit'
    ]);
    $router->put('categories/{category}', [
        'as' => 'admin.content.category.update',
        'uses' => 'CategoryController@update',
        'middleware' => 'can:content.categories.edit'
    ]);
    $router->delete('categories/{category}', [
        'as' => 'admin.content.category.destroy',
        'uses' => 'CategoryController@destroy',
        'middleware' => 'can:content.categories.destroy'
    ]);
    $router->bind('contentimages', function ($id) {
        return app('Modules\Content\Repositories\ContentImagesRepository')->find($id);
    });
    $router->get('contentimages', [
        'as' => 'admin.content.contentimages.index',
        'uses' => 'ContentImagesController@index',
        'middleware' => 'can:content.contentimages.index'
    ]);
    $router->get('contentimages/create', [
        'as' => 'admin.content.contentimages.create',
        'uses' => 'ContentImagesController@create',
        'middleware' => 'can:content.contentimages.create'
    ]);
    $router->post('contentimages', [
        'as' => 'admin.content.contentimages.store',
        'uses' => 'ContentImagesController@store',
        'middleware' => 'can:content.contentimages.create'
    ]);
    $router->get('contentimages/{contentimages}/edit', [
        'as' => 'admin.content.contentimages.edit',
        'uses' => 'ContentImagesController@edit',
        'middleware' => 'can:content.contentimages.edit'
    ]);
    $router->put('contentimages/{contentimages}', [
        'as' => 'admin.content.contentimages.update',
        'uses' => 'ContentImagesController@update',
        'middleware' => 'can:content.contentimages.edit'
    ]);
    $router->delete('contentimages/{contentimages}', [
        'as' => 'admin.content.contentimages.destroy',
        'uses' => 'ContentImagesController@destroy',
        'middleware' => 'can:content.contentimages.destroy'
    ]);
// append



});
