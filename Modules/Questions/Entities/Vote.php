<?php

namespace Modules\Questions\Entities;

//use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    //use Translatable;

    protected $table = 'questions__votes';
    //public $translatedAttributes = [];
    protected $fillable = ['user_id', 'question_id', 'answer_id'];
}
