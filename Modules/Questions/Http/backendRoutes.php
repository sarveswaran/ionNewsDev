<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/questions'], function (Router $router) {
    $router->bind('questions', function ($id) {
        return app('Modules\Questions\Repositories\QuestionsRepository')->find($id);
    });
    $router->get('questions', [
        'as' => 'admin.questions.questions.index',
        'uses' => 'QuestionsController@index',
        'middleware' => 'can:questions.questions.index'
    ]);
    $router->get('questions/create', [
        'as' => 'admin.questions.questions.create',
        'uses' => 'QuestionsController@create',
        'middleware' => 'can:questions.questions.create'
    ]);
    $router->post('questions', [
        'as' => 'admin.questions.questions.store',
        'uses' => 'QuestionsController@store',
        'middleware' => 'can:questions.questions.create'
    ]);
    $router->get('questions/{questions}/edit', [
        'as' => 'admin.questions.questions.edit',
        'uses' => 'QuestionsController@edit',
        'middleware' => 'can:questions.questions.edit'
    ]);
    $router->put('questions/{questions}', [
        'as' => 'admin.questions.questions.update',
        'uses' => 'QuestionsController@update',
        'middleware' => 'can:questions.questions.edit'
    ]);
    $router->delete('questions/{questions}', [
        'as' => 'admin.questions.questions.destroy',
        'uses' => 'QuestionsController@destroy',
        'middleware' => 'can:questions.questions.destroy'
    ]);
    $router->bind('likes', function ($id) {
        return app('Modules\Questions\Repositories\LikesRepository')->find($id);
    });
    $router->get('likes', [
        'as' => 'admin.questions.likes.index',
        'uses' => 'LikesController@index',
        'middleware' => 'can:questions.likes.index'
    ]);
    $router->get('likes/create', [
        'as' => 'admin.questions.likes.create',
        'uses' => 'LikesController@create',
        'middleware' => 'can:questions.likes.create'
    ]);
    $router->post('likes', [
        'as' => 'admin.questions.likes.store',
        'uses' => 'LikesController@store',
        'middleware' => 'can:questions.likes.create'
    ]);
    $router->get('likes/{likes}/edit', [
        'as' => 'admin.questions.likes.edit',
        'uses' => 'LikesController@edit',
        'middleware' => 'can:questions.likes.edit'
    ]);
    $router->put('likes/{likes}', [
        'as' => 'admin.questions.likes.update',
        'uses' => 'LikesController@update',
        'middleware' => 'can:questions.likes.edit'
    ]);
    $router->delete('likes/{likes}', [
        'as' => 'admin.questions.likes.destroy',
        'uses' => 'LikesController@destroy',
        'middleware' => 'can:questions.likes.destroy'
    ]);
    $router->bind('comments', function ($id) {
        return app('Modules\Questions\Repositories\CommentsRepository')->find($id);
    });
    $router->get('comments', [
        'as' => 'admin.questions.comments.index',
        'uses' => 'CommentsController@index',
        'middleware' => 'can:questions.comments.index'
    ]);
    $router->get('comments/create', [
        'as' => 'admin.questions.comments.create',
        'uses' => 'CommentsController@create',
        'middleware' => 'can:questions.comments.create'
    ]);
    $router->post('comments', [
        'as' => 'admin.questions.comments.store',
        'uses' => 'CommentsController@store',
        'middleware' => 'can:questions.comments.create'
    ]);
    $router->get('comments/{comments}/edit', [
        'as' => 'admin.questions.comments.edit',
        'uses' => 'CommentsController@edit',
        'middleware' => 'can:questions.comments.edit'
    ]);
    $router->put('comments/{comments}', [
        'as' => 'admin.questions.comments.update',
        'uses' => 'CommentsController@update',
        'middleware' => 'can:questions.comments.edit'
    ]);
    $router->delete('comments/{comments}', [
        'as' => 'admin.questions.comments.destroy',
        'uses' => 'CommentsController@destroy',
        'middleware' => 'can:questions.comments.destroy'
    ]);
// append



});
