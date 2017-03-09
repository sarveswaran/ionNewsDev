<?php

namespace Modules\Content\Repositories\Cache;

use Modules\Content\Repositories\ContentImagesRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheContentImagesDecorator extends BaseCacheDecorator implements ContentImagesRepository
{
    public function __construct(ContentImagesRepository $contentimages)
    {
        parent::__construct();
        $this->entityName = 'content.contentimages';
        $this->repository = $contentimages;
    }
}
