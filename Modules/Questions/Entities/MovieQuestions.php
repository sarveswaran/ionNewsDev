<?php

namespace Modules\Questions\Entities;

use Illuminate\Database\Eloquent\Model;

class MovieQuestions extends Model
{
    protected $table = 'questions__moviequestions';
    protected $fillable = ['question'];
}
