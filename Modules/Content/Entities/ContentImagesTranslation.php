<?php

namespace Modules\Content\Entities;

use Illuminate\Database\Eloquent\Model;

class ContentImagesTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'content__images_trans';
}
