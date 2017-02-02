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
    	$comment = $this->comments->create($request->all());
    	return Response::json(['comment' => $comment]);
    }
}