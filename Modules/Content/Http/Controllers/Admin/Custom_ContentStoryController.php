<?php

namespace Modules\Content\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Content\Entities\Custom_ContentStory;
use Modules\Content\Repositories\Custom_ContentStoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use DB;
use Log;

class Custom_ContentStoryController extends AdminBaseController
{
    /**
     * @var Custom_ContentStoryRepository
     */
    private $custom_contentstory;

    public function __construct(Custom_ContentStoryRepository $custom_contentstory)
    {
        parent::__construct();

        $this->custom_contentstory = $custom_contentstory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $custom_contentstories = $this->custom_contentstory->all();
        Log::info($custom_contentstories); 

        return view('content::admin.custom_contentstories.index', compact('custom_contentstories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('content::admin.custom_contentstories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {   
         Log::info($request->all()); die;
        $this->custom_contentstory->create($request->all());

        return redirect()->route('admin.content.custom_contentstory.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('content::custom_contentstories.title.custom_contentstories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Custom_ContentStory $custom_contentstory
     * @return Response
     */
    public function edit(Custom_ContentStory $custom_contentstory)
    {
        return view('content::admin.custom_contentstories.edit', compact('custom_contentstory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Custom_ContentStory $custom_contentstory
     * @param  Request $request
     * @return Response
     */
    public function update(Custom_ContentStory $custom_contentstory, Request $request)
    {
        $this->custom_contentstory->update($custom_contentstory, $request->all());

        return redirect()->route('admin.content.custom_contentstory.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('content::custom_contentstories.title.custom_contentstories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Custom_ContentStory $custom_contentstory
     * @return Response
     */
    public function destroy(Custom_ContentStory $custom_contentstory)
    {
        $this->custom_contentstory->destroy($custom_contentstory);

        return redirect()->route('admin.content.custom_contentstory.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('content::custom_contentstories.title.custom_contentstories')]));
    }
}
