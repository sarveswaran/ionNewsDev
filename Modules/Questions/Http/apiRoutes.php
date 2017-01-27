<?php

use Illuminate\Routing\Router;

$router->get('questions', [
    'as' => 'api.get.questions',
    'uses' => 'QuestionsApiController@index'
]);

$router->post('vote', [
    'as' => 'api.post.vote',
    'uses' => 'QuestionsApiController@vote',
    'middleware' => 'auth'
]);

$router->post('comment', [
    'as' => 'api.post.comment',
    'uses' => 'CommentsApiController@comment',
    'middleware' => 'auth'
]);