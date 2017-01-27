<?php

namespace Modules\Questions\Repositories\Cache;

use Modules\Questions\Repositories\QuestionsRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheQuestionsDecorator extends BaseCacheDecorator implements QuestionsRepository
{
    public function __construct(QuestionsRepository $questions)
    {
        parent::__construct();
        $this->entityName = 'questions.questions';
        $this->repository = $questions;
    }
}
