<?php

namespace Modules\Questions\Entities;

use Illuminate\Database\Eloquent\Model;

class VoteTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'questions__vote_translations';
}
