<?php

namespace Modules\Questions\Entities;

//use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    //use Translatable;

    protected $table = 'questions__questions';
    //public $translatedAttributes = [];
    protected $fillable = ['question', 'answer_1', 'answer_2', 'answer_3', 'answer_4', 'answer_5', 'category_id', 'user_id','status'];
}
