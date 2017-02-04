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
        $nowquestion = $this->questions->find($request->question_id);
        $votes = $this->vote->getByAttributes(['question_id' => $request->question_id])->groupBy('answer');
        $nowquestion->answer1_count = 0;
        $nowquestion->answer2_count = 0;
        $nowquestion->answer3_count = 0;
        $nowquestion->answer4_count = 0;
        $nowquestion->answer5_count = 0;


        foreach ($votes as $key => $value) {

            if($nowquestion->answer_1 == $key){

                $nowquestion->answer1_count = count($value);

            }elseif($nowquestion->answer_2 == $key){

                $nowquestion->answer2_count = count($value);
        

            }elseif($nowquestion->answer_3 == $key){

                $nowquestion->answer3_count = count($value);

            }elseif($nowquestion->answer_4 == $key){

                $nowquestion->answer4_count = count($value);

            }elseif($nowquestion->answer_5 == $key){

                $nowquestion->answer5_count = count($value);
            }

            //$votes[$key] = count($value);
        }

        return Response::json($nowquestion);
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
        $all = $this->questions->findByAttributes(['category_id' => $category]);
        if(isset($all->id)){
            $questions = $this->questions->catfilter($category);
            return Response::json($questions);
        }else{
             return Response::json(['message' => 'no data']);
        }
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
