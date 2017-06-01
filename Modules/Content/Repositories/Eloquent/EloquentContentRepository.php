<?php

namespace Modules\Content\Repositories\Eloquent;

use Modules\Content\Repositories\ContentRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentContentRepository extends EloquentBaseRepository implements ContentRepository
{

	public function filter($field,$value){

		$story =  $this->model
				->where($field, '=', $value)
				->orderBy('id', 'desc')
        		->paginate(12);
         return $story;	

	}
}
