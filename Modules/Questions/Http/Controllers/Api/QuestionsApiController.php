<?php

namespace Modules\Questions\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Questions\Entities\Questions;
use Modules\Questions\Repositories\QuestionsRepository;
use Modules\Questions\Entities\Vote;
use Modules\Questions\Repositories\VoteRepository;
use Modules\Questions\Http\Requests\Vote;

class QuestionsApiController extends Controller
{

    public function __construct(QuestionsRepository $questions, VoteRepository $vote)
    {
        $this->questions = $questions;
        $this->vote = $vote;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $questions = $this->questions->paginate();
        return Response::json(['questions' => $questions]);
    }

    /**
     * Post a vote to a question
     *
     * @return Response
     */
    public function vote(Vote $request)
    {
        $vote = $this->vote->create($request->all());
        return Response::json(['vote' => $vote]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  File     $file
     * @return Response
     */
    public function edit(File $file)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  File               $file
     * @param  UpdateMediaRequest $request
     * @return Response
     */
    public function update(File $file, UpdateMediaRequest $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  File     $file
     * @internal param int $id
     * @return Response
     */
    public function destroy(File $file)
    {
        
    }
}
