<?php

namespace Modules\Questions\Repositories\Eloquent;

use Modules\Questions\Repositories\QuestionsRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentQuestionsRepository extends EloquentBaseRepository implements QuestionsRepository
{
	public function catfilter($catid){
		if($catid == 1){

			$cat =  $this->model
						->where('trend', '=',1)
						->where('status','=',1)
						->orderBy('id', 'desc')
                		->paginate(15);
         return $cat;	


		}else{
			$cat =  $this->model
						->where('category_id', '=',$catid)
						->where('status','=',1)
						->orderBy('id', 'desc')
                		->paginate(15);
         	return $cat;	
    	 }

	}

	public function myfilter($userid){
			$list =  $this->model
						->where('user_id', '=',$userid)
						->orderBy('id', 'desc')
                		->paginate(15);
         return $list;	

	}
}
