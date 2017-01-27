<?php

namespace Modules\Questions\Entities;

use Illuminate\Database\Eloquent\Model;

class CommentsTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'questions__comments_translations';
}
