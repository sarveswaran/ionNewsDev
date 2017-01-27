<?php

namespace Modules\Questions\Entities;

//use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    //use Translatable;

    protected $table = 'questions__questions';
    //public $translatedAttributes = [];
    protected $fillable = [];
}
