<?php

namespace Modules\Content\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Content\Entities\ContentImages;
use Modules\Content\Repositories\ContentImagesRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ContentImagesController extends AdminBaseController
{
    /**
     * @var ContentImagesRepository
     */
    private $contentimages;

    public function __construct(ContentImagesRepository $contentimages)
    {
        parent::__construct();

        $this->contentimages = $contentimages;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$contentimages = $this->contentimages->all();

        return view('content::admin.contentimages.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('content::admin.contentimages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->contentimages->create($request->all());

        return redirect()->route('admin.content.contentimages.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('content::contentimages.title.contentimages')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ContentImages $contentimages
     * @return Response
     */
    public function edit(ContentImages $contentimages)
    {
        return view('content::admin.contentimages.edit', compact('contentimages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ContentImages $contentimages
     * @param  Request $request
     * @return Response
     */
    public function update(ContentImages $contentimages, Request $request)
    {
        $this->contentimages->update($contentimages, $request->all());

        return redirect()->route('admin.content.contentimages.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('content::contentimages.title.contentimages')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ContentImages $contentimages
     * @return Response
     */
    public function destroy(ContentImages $contentimages)
    {
        $this->contentimages->destroy($contentimages);

        return redirect()->route('admin.content.contentimages.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('content::contentimages.title.contentimages')]));
    }
}
