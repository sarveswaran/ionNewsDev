<?php

namespace Modules\Questions\Repositories\Cache;

use Modules\Questions\Repositories\MovieQuestionsRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheMovieQuestionsDecorator extends BaseCacheDecorator implements MovieQuestionsRepository
{
    public function __construct(MovieQuestionsRepository $moviequestions)
    {
        parent::__construct();
        $this->entityName = 'questions.moviequestions';
        $this->repository = $moviequestions;
    }
}
