<?php

namespace Modules\Questions\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
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
    	$comment = $this->comments->create($request->all());
    	return Response::json(['comment' => $comment]);
    }
}