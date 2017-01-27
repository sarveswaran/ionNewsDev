<?php

namespace Modules\Questions\Entities;

use Illuminate\Database\Eloquent\Model;

class QuestionsTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'questions__questions_translations';
}
