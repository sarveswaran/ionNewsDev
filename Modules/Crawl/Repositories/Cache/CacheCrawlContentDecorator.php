<?php

namespace Modules\Crawl\Repositories\Cache;

use Modules\Crawl\Repositories\CrawlContentRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCrawlContentDecorator extends BaseCacheDecorator implements CrawlContentRepository
{
    public function __construct(CrawlContentRepository $crawlcontent)
    {
        parent::__construct();
        $this->entityName = 'crawl.crawlcontents';
        $this->repository = $crawlcontent;
    }
}
