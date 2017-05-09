<?php

namespace Modules\Content\Repositories\Eloquent;

use Modules\Content\Repositories\ContentRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use DB;

class EloquentContentRepository extends EloquentBaseRepository implements ContentRepository
{

	public function filter($field,$value){

		$story =  DB::table('content__contents as cc')
                  ->join('content__multiplecategorycontents as cm','cm.content_id','=','cc.id')
                ->select('cc.*' )
				->where('cm.category_id', '=', $value)
				->orderBy('cc.id', 'desc')
        		->paginate(12);
         return $story;	

	}
}
