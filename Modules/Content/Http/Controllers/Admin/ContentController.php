<?php

namespace Modules\Content\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Content\Entities\Content;
use Modules\Content\Repositories\ContentRepository;
use Modules\Content\Repositories\CategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ContentController extends AdminBaseController
{
    /**
     * @var ContentRepository
     */
    private $content;

    public function __construct(ContentRepository $content,CategoryRepository $category)
    {
        parent::__construct();

        $this->category = $category;
        $this->content = $content;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {   
        $categories = $this->category->getByAttributes(['status' => 1]);
        $contents = $this->content->all();

        return view('content::admin.contents.index', compact('contents','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->category->getByAttributes(['status' => 1]);
        return view('content::admin.contents.create',compact('categories'));
    }


    public function ajaxcall(Request $request)
    {
        return array('title' => 'sports title','sub_title' => 'sports  best person in the world','content' => 'm,sdm, dsd,msndmsds dssddsd sdddsds dsd');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //$uploadedfiles = $request->file('filebox');
       
        $this->content->create($request->all());

        return redirect()->route('admin.content.content.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('content::contents.title.contents')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Content $content
     * @return Response
     */
    public function edit(Content $content)
    {
        $categories = $this->category->getByAttributes(['status' => 1]);
        return view('content::admin.contents.edit', compact('content','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Content $content
     * @param  Request $request
     * @return Response
     */
    public function update(Content $content, Request $request)
    {
        $this->content->update($content, $request->all());

        return redirect()->route('admin.content.content.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('content::contents.title.contents')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Content $content
     * @return Response
     */
    public function destroy(Content $content)
    {
        $this->content->destroy($content);

        return redirect()->route('admin.content.content.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('content::contents.title.contents')]));
    }
}
