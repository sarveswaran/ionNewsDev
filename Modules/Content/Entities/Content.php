<?php

namespace Modules\Content\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use Translatable;

    protected $table = 'content__contents';
    public $translatedAttributes = [];
    protected $fillable = [];
}
