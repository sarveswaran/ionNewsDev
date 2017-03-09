<?php

namespace Modules\Content\Entities;

use Illuminate\Database\Eloquent\Model;

class ContentTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'content__content_trans';
}
