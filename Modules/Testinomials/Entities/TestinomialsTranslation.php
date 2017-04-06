<?php

namespace Modules\Testinomials\Entities;

use Illuminate\Database\Eloquent\Model;

class TestinomialsTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'testinomials__testinomials_translations';
}
