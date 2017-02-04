<?php

namespace Modules\Questions\Repositories\Eloquent;

use Modules\Questions\Repositories\QuestionsRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentQuestionsRepository extends EloquentBaseRepository implements QuestionsRepository
{
	public function catfilter($catid){
			$dispensary =  $this->model
						->where('category_id', '=',$catid)
						->orderBy('id', 'desc')
                		->paginate(15);
         return $dispensary;	

	}
}
