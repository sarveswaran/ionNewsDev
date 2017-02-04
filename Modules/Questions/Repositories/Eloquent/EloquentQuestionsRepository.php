<?php

namespace Modules\Questions\Repositories\Eloquent;

use Modules\Questions\Repositories\QuestionsRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentQuestionsRepository extends EloquentBaseRepository implements QuestionsRepository
{
	public function catfilter($catid){
			$cat =  $this->model
						->where('category_id', '=',$catid)
						->orderBy('id', 'desc')
                		->paginate(15);
         return $cat;	

	}

	public function myfilter($userid){
			$list =  $this->model
						->where('user_id', '=',$userid)
						->orderBy('id', 'desc')
                		->paginate(15);
         return $list;	

	}
}
