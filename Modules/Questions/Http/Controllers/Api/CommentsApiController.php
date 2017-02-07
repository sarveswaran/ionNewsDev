<?php

namespace Modules\Questions\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Questions\Entities\Comments;
use Modules\Questions\Repositories\CommentsRepository;
use Modules\Questions\Http\Requests\Comment;

class CommentsApiController extends Controller
{
	public function __construct(CommentsRepository $comments)
    {
        $this->comments = $comments;
    }

    public function comment(Comment $request)
    {
    	$request['user_id'] = Auth::user()->id;
        $exists = $this->comments->findByAttributes(['question_id' => $request->question_id ,'user_id' => $request['user_id']]);
        if(!isset($exists->id)){
        	$comment = $this->comments->create($request->all());

           $content =   $this->comments->getByAttributes(['question_id' => $request->question_id]);
           //$content->message =  'successfully posted';
    
        }else{
          $content =  $this->comments->getByAttributes(['question_id' => $request->question_id]);
          //$content->message =  'already comment posted';
        }

        return $content;
    }

    public function getcomment($question_id){

      return $this->comments->getByAttributes(['question_id' => $question_id]);

    }
}