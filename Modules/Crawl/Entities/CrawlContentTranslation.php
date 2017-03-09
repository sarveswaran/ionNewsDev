<?php

namespace Modules\Crawl\Entities;

use Illuminate\Database\Eloquent\Model;

class CrawlContentTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'crawl__crawlcontent_translations';
}
