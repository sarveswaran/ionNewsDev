<?php

namespace Modules\Questions\Repositories\Cache;

use Modules\Questions\Repositories\VoteRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheVoteDecorator extends BaseCacheDecorator implements VoteRepository
{
    public function __construct(VoteRepository $vote)
    {
        parent::__construct();
        $this->entityName = 'questions.votes';
        $this->repository = $vote;
    }
}
