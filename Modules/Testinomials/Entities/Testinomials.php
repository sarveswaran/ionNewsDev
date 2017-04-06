<?php

namespace Modules\Testinomials\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Testinomials extends Model
{
    use Translatable;

    protected $table = 'testinomials__testinomials';
    public $translatedAttributes = [];
    protected $fillable = [];
}
