<?php

namespace Modules\Content\Repositories\Eloquent;

use Modules\Content\Repositories\ContentRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use DB;

class EloquentContentRepository extends EloquentBaseRepository implements ContentRepository
{

	public function filter($category_id,$user_id){

		$current_date=date('Y-m-d');
		$story =  DB::table('content__contents as cc')
		          ->join('content__contentusers as cu', 'cu.content_id','=','cc.id')
                  ->join('content__multiplecategorycontents as cm','cm.content_id','=','cc.id')
                ->select('cc.*' )
				->where('cm.category_id', '=', $category_id)
				->where('cc.expiry_date','>=',$current_date)
				->where('cu.user_id','=',$user_id)
				->orderBy('cc.id', 'desc')
        		->paginate(12);
         return $story;	

	}
}
