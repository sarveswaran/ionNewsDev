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

$router->get('questions/category/{category}', [
    'as' => 'api.get.questions.category',
    'uses' => 'QuestionsApiController@categoryQuestions'
]);

$router->get('category/list', [
    'as' => 'api.get.category.list',
    'uses' => 'QuestionsApiController@listOfCategories'
]);