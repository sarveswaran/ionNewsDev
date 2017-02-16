<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/authentication'], function (Router $router) {
Route::group(['middleware' => 'cors'], function(Router $router){
	 $router->post('/login', [
        'as' => 'authentication.api.login',
        'uses' => 'FrontController@login'
    ]);
	 $router->get('/user', [
        'as' => 'authentication.api.userDetails',
        'uses' => 'FrontController@userDetails',
        'middleware' => 'auth:api'
    ]);
     $router->post('/register', [
        'as' => 'authentication.api.register',
        'uses' => 'FrontController@register'
    ]);
     $router->post('/forgot', [
        'as' => 'authentication.api.forgotpassword',
        'uses' => 'FrontController@forgotpassword'
    ]);
     $router->post('/updateuserinfo', [
        'as' => 'authentication.api.updateuserinfo',
        'uses' => 'FrontController@updateuserinfo',
        'middleware' => 'auth:api'
    ]);
    $router->post('/getactive', [
        'as' => 'authentication.api.getactive',
        'uses' => 'FrontController@getactive'
    ]);
     $router->post('/registerfamily', [
        'as' => 'contact.api.registerfamily',
        'uses' => 'FrontController@registerfamily',
        'middleware' => 'auth:api'
    ]);
    $router->post('/removemember', [
        'as' => 'contact.api.removemember',
        'uses' => 'FrontController@removemember',
        'middleware' => 'auth:api'
    ]);
    $router->get('/members', [
        'as' => 'contact.api.members',
        'uses' => 'FrontController@members',
        'middleware' => 'auth:api'
    ]);
});
});
		
