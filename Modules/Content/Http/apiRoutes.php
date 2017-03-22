<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/story'], function (Router $router) {
Route::group(['middleware' => 'cors'], function(Router $router){
	 $router->get('/list', [
        'as' => 'StoryController.api.story',
        'uses' => 'StoryController@story',
        'middleware' => 'auth:api'
    ]);
});
});

$router->group(['prefix' =>'/category'], function (Router $router) {
Route::group(['middleware' => 'cors'], function(Router $router){
     $router->get('/list', [
        'as' => 'CategoryController.api.categorylist',
        'uses' => 'CategoryController@categorylist'
    ]);
});
});
		
