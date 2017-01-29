<?php

namespace Modules\Questions\Repositories\Cache;

use Modules\Questions\Repositories\CategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategoryDecorator extends BaseCacheDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'questions.categories';
        $this->repository = $category;
    }
}
