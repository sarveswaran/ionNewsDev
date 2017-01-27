<?php

namespace Modules\Questions\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Questions\Entities\Vote;
use Modules\Questions\Repositories\VoteRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class VoteController extends AdminBaseController
{
    /**
     * @var VoteRepository
     */
    private $vote;

    public function __construct(VoteRepository $vote)
    {
        parent::__construct();

        $this->vote = $vote;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$votes = $this->vote->all();

        return view('questions::admin.votes.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('questions::admin.votes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->vote->create($request->all());

        return redirect()->route('admin.questions.vote.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('questions::votes.title.votes')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Vote $vote
     * @return Response
     */
    public function edit(Vote $vote)
    {
        return view('questions::admin.votes.edit', compact('vote'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Vote $vote
     * @param  Request $request
     * @return Response
     */
    public function update(Vote $vote, Request $request)
    {
        $this->vote->update($vote, $request->all());

        return redirect()->route('admin.questions.vote.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('questions::votes.title.votes')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Vote $vote
     * @return Response
     */
    public function destroy(Vote $vote)
    {
        $this->vote->destroy($vote);

        return redirect()->route('admin.questions.vote.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('questions::votes.title.votes')]));
    }
}
