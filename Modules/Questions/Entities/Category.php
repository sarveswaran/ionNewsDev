<?php

namespace Modules\Questions\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    protected $table = 'questions__categories';
    public $translatedAttributes = [];
    protected $fillable = ['name', 'slug','status'];
}
