<?php

namespace Modules\Testinomials\Repositories\Cache;

use Modules\Testinomials\Repositories\TestinomialsRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTestinomialsDecorator extends BaseCacheDecorator implements TestinomialsRepository
{
    public function __construct(TestinomialsRepository $testinomials)
    {
        parent::__construct();
        $this->entityName = 'testinomials.testinomials';
        $this->repository = $testinomials;
    }
}
