<?php

namespace Modules\Questions\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Questions\Entities\Likes;
use Modules\Questions\Repositories\LikesRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class LikesController extends AdminBaseController
{
    /**
     * @var LikesRepository
     */
    private $likes;

    public function __construct(LikesRepository $likes)
    {
        parent::__construct();

        $this->likes = $likes;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$likes = $this->likes->all();

        return view('questions::admin.likes.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('questions::admin.likes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->likes->create($request->all());

        return redirect()->route('admin.questions.likes.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('questions::likes.title.likes')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Likes $likes
     * @return Response
     */
    public function edit(Likes $likes)
    {
        return view('questions::admin.likes.edit', compact('likes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Likes $likes
     * @param  Request $request
     * @return Response
     */
    public function update(Likes $likes, Request $request)
    {
        $this->likes->update($likes, $request->all());

        return redirect()->route('admin.questions.likes.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('questions::likes.title.likes')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Likes $likes
     * @return Response
     */
    public function destroy(Likes $likes)
    {
        $this->likes->destroy($likes);

        return redirect()->route('admin.questions.likes.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('questions::likes.title.likes')]));
    }
}
