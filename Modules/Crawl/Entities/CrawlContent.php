<?php

namespace Modules\Crawl\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CrawlContent extends Model
{
    use Translatable;

    protected $table = 'crawl__crawlcontents';
    public $translatedAttributes = [];
    protected $fillable = [];
}
