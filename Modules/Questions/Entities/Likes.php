<?php

namespace Modules\Questions\Entities;

//use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    //use Translatable;

    protected $table = 'questions__likes';
    //public $translatedAttributes = [];
    protected $fillable = [];
}
