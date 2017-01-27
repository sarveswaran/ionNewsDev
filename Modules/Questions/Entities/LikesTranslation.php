<?php

namespace Modules\Questions\Entities;

use Illuminate\Database\Eloquent\Model;

class LikesTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'questions__likes_translations';
}
