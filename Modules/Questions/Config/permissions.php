<?php

return [
    'questions.questions' => [
        'index' => 'questions::questions.list resource',
        'create' => 'questions::questions.create resource',
        'edit' => 'questions::questions.edit resource',
        'destroy' => 'questions::questions.destroy resource',
    ],
    'questions.likes' => [
        'index' => 'questions::likes.list resource',
        'create' => 'questions::likes.create resource',
        'edit' => 'questions::likes.edit resource',
        'destroy' => 'questions::likes.destroy resource',
    ],
    'questions.comments' => [
        'index' => 'questions::comments.list resource',
        'create' => 'questions::comments.create resource',
        'edit' => 'questions::comments.edit resource',
        'destroy' => 'questions::comments.destroy resource',
    ],
// append



];
