<?php

namespace Modules\Questions\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Questions\Entities\Questions;
use Modules\Questions\Repositories\QuestionsRepository;
use Modules\Questions\Entities\Vote;
use Modules\Questions\Repositories\VoteRepository;
use Modules\Questions\Repositories\CategoryRepository;
use Modules\Questions\Http\Requests\VoteRequest;
use Modules\Questions\Http\Requests\CreateQuestionRequestByUser;
use Log;

class QuestionsApiController extends Controller
{

    public function __construct(QuestionsRepository $questions, VoteRepository $vote, CategoryRepository $categoryRepository)
    {
        $this->questions = $questions;
        $this->vote = $vote;
        $this->categoryRepository = $categoryRepository;
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
    public function vote(VoteRequest $request)
    {
        $request['user_id'] = Auth::user()->id;
        $vote = $this->vote->create($request->all());

        $votes = $this->vote->getByAttributes(['question_id' => $request->question_id])->groupBy('answer_id');

        foreach ($votes as $key => $value) {
            $votes[$key] = count($value);
        }

        return Response::json($votes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(CreateQuestionRequestByUser $request)
    {
        $request['user_id'] = Auth::user()->id;
        $request['answer_5'] = 'Nota';
        $question = $this->questions->create($request->all());
        return Response::json($question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  File     $file
     * @return Response
     */
    public function categoryQuestions($category)
    {
        $questions = $this->questions->findByAttributes(['category_id' => $category])->paginate();
        return Response::json($questions);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  File     $file
     * @return Response
     */
    public function listOfCategories()
    {
        $categories = $this->categoryRepository->all();
        return Response::json($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  File               $file
     * @param  UpdateMediaRequest $request
     * @return Response
     */
    public function myQuestions()
    {
        $questions = $this->questions->findByAttributes(['user_id' => Auth::user()->id])->paginate();
        return Response::json($questions);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  File     $file
     * @internal param int $id
     * @return Response
     */
    public function destroy()
    {
        
    }
}
