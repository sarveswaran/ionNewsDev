<?php

namespace Modules\Questions\Repositories\Cache;

use Modules\Questions\Repositories\LikesRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheLikesDecorator extends BaseCacheDecorator implements LikesRepository
{
    public function __construct(LikesRepository $likes)
    {
        parent::__construct();
        $this->entityName = 'questions.likes';
        $this->repository = $likes;
    }
}
