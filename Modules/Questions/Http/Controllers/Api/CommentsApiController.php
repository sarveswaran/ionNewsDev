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
        $exists = $this->comments->getByAttributes(['question_id' => $request->question_id ,'user_id' => $request['user_id']]);
        $val = count($exists);
        if($val < 20){
        	$comment = $this->comments->create($request->all());

           $content =   $this->comments->getByAttributes(['question_id' => $request->question_id]);
           //$content->message =  'successfully posted';
    
        }else{
          $content =  $this->comments->getByAttributes(['question_id' => $request->question_id]);
          //$content->message =  'already comment posted';
        }

        foreach ($content as $cont) {
            $cont->user;
            $cont->name = $cont->user->first_name.' '.$cont->user->last_name;

        }

        return $content;
    }

    public function getcomment($question_id){

      $comments = $this->comments->getByAttributes(['question_id' => $question_id]);

      if(!$comments || count($comments) < 1){

        return $comments;
      }
      foreach ($comments as $comment) {
        $comment->user;
        $comment->name = $comment->user->first_name.' '.$comment->user->last_name;

      }

      return $comments;

    }
}