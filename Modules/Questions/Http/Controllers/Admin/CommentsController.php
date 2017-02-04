<?php

namespace Modules\Questions\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Questions\Entities\Comments;
use Modules\Questions\Repositories\CommentsRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CommentsController extends AdminBaseController
{
    /**
     * @var CommentsRepository
     */
    private $comments;

    public function __construct(CommentsRepository $comments)
    {
        parent::__construct();

        $this->comments = $comments;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $comments = $this->comments->all();

        return view('questions::admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('questions::admin.comments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->comments->create($request->all());

        return redirect()->route('admin.questions.comments.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('questions::comments.title.comments')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Comments $comments
     * @return Response
     */
    public function edit(Comments $comments)
    {
        return view('questions::admin.comments.edit', compact('comments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Comments $comments
     * @param  Request $request
     * @return Response
     */
    public function update(Comments $comments, Request $request)
    {
        $this->comments->update($comments, $request->all());

        return redirect()->route('admin.questions.comments.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('questions::comments.title.comments')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Comments $comments
     * @return Response
     */
    public function destroy(Comments $comments)
    {
        $this->comments->destroy($comments);

        return redirect()->route('admin.questions.comments.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('questions::comments.title.comments')]));
    }
}
