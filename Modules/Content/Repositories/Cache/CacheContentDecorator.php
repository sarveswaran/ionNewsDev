<?php

namespace Modules\Content\Repositories\Cache;

use Modules\Content\Repositories\ContentRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheContentDecorator extends BaseCacheDecorator implements ContentRepository
{
    public function __construct(ContentRepository $content)
    {
        parent::__construct();
        $this->entityName = 'content.contents';
        $this->repository = $content;
    }

    public function filter($field,$value){
    	
    	return $this->repository->filter($field,$value);
    }
}
