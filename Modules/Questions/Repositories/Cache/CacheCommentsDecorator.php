<?php

namespace Modules\Questions\Repositories\Cache;

use Modules\Questions\Repositories\CommentsRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCommentsDecorator extends BaseCacheDecorator implements CommentsRepository
{
    public function __construct(CommentsRepository $comments)
    {
        parent::__construct();
        $this->entityName = 'questions.comments';
        $this->repository = $comments;
    }
}
