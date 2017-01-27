<?php

namespace Modules\Questions\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Questions\Entities\Questions;
use Modules\Questions\Repositories\QuestionsRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class QuestionsController extends AdminBaseController
{
    /**
     * @var QuestionsRepository
     */
    private $questions;

    public function __construct(QuestionsRepository $questions)
    {
        parent::__construct();

        $this->questions = $questions;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$questions = $this->questions->all();

        return view('questions::admin.questions.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('questions::admin.questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->questions->create($request->all());

        return redirect()->route('admin.questions.questions.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('questions::questions.title.questions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Questions $questions
     * @return Response
     */
    public function edit(Questions $questions)
    {
        return view('questions::admin.questions.edit', compact('questions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Questions $questions
     * @param  Request $request
     * @return Response
     */
    public function update(Questions $questions, Request $request)
    {
        $this->questions->update($questions, $request->all());

        return redirect()->route('admin.questions.questions.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('questions::questions.title.questions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Questions $questions
     * @return Response
     */
    public function destroy(Questions $questions)
    {
        $this->questions->destroy($questions);

        return redirect()->route('admin.questions.questions.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('questions::questions.title.questions')]));
    }
}
