<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/testinomials'], function (Router $router) {
    $router->bind('testinomials', function ($id) {
        return app('Modules\Testinomials\Repositories\TestinomialsRepository')->find($id);
    });
    $router->get('testinomials', [
        'as' => 'admin.testinomials.testinomials.index',
        'uses' => 'TestinomialsController@index',
        'middleware' => 'can:testinomials.testinomials.index'
    ]);
    $router->get('testinomials/create', [
        'as' => 'admin.testinomials.testinomials.create',
        'uses' => 'TestinomialsController@create',
        'middleware' => 'can:testinomials.testinomials.create'
    ]);
    $router->post('testinomials', [
        'as' => 'admin.testinomials.testinomials.store',
        'uses' => 'TestinomialsController@store',
        'middleware' => 'can:testinomials.testinomials.create'
    ]);
    $router->get('testinomials/{testinomials}/edit', [
        'as' => 'admin.testinomials.testinomials.edit',
        'uses' => 'TestinomialsController@edit',
        'middleware' => 'can:testinomials.testinomials.edit'
    ]);
    $router->put('testinomials/{testinomials}', [
        'as' => 'admin.testinomials.testinomials.update',
        'uses' => 'TestinomialsController@update',
        'middleware' => 'can:testinomials.testinomials.edit'
    ]);
    $router->delete('testinomials/{testinomials}', [
        'as' => 'admin.testinomials.testinomials.destroy',
        'uses' => 'TestinomialsController@destroy',
        'middleware' => 'can:testinomials.testinomials.destroy'
    ]);
// append

});
