<?php

namespace Modules\Questions\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Media\Image\ThumbnailManager;
use Modules\Media\Repositories\FileRepository;
use Modules\Questions\Entities\MovieQuestions;
use Modules\Media\Http\Controllers\Api\MediaController;
use Modules\Questions\Repositories\MovieQuestionsRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class MovieQuestionsController extends AdminBaseController
{
    /**
     * @var MovieQuestionsRepository
     */
    private $moviequestions;

    public function __construct(MovieQuestionsRepository $moviequestions, FileRepository $fileRepository, ThumbnailManager $thumbnailsManager)
    {
        parent::__construct();

        $this->moviequestions = $moviequestions;
        $this->file = $fileRepository;
        $this->thumbnailsManager = $thumbnailsManager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$moviequestions = $this->moviequestions->all();

        return view('questions::admin.moviequestions.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('questions::admin.moviequestions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, MediaController $media)
    {
        $this->moviequestions->create($request->all());

        // if(!empty($request['medias_single'])) {
        //     foreach ($request['medias_single'] as $zone => $image_id) {
        //         $request['mediaId'] = $image_id;
        //         $request['_token'] = $request['_token'];
        //         $request['entityClass'] = 'Modules\Questions\Entities\MovieQuestions';
        //         $request['entityId'] = $property['id'];
        //         $request['zone'] = $zone;
        //         $media->linkMedia($request);
        //     }
        // }

        return redirect()->route('admin.questions.moviequestions.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('questions::moviequestions.title.moviequestions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  MovieQuestions $moviequestions
     * @return Response
     */
    public function edit(MovieQuestions $moviequestions)
    {
        // $movieimage = $this->file->findFileByZoneForEntity('movieimage', $residentialproperties);
        return view('questions::admin.moviequestions.edit', compact('moviequestions', 'movieimage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MovieQuestions $moviequestions
     * @param  Request $request
     * @return Response
     */
    public function update(MovieQuestions $moviequestions, Request $request)
    {
        $this->moviequestions->update($moviequestions, $request->all());

        return redirect()->route('admin.questions.moviequestions.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('questions::moviequestions.title.moviequestions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  MovieQuestions $moviequestions
     * @return Response
     */
    public function destroy(MovieQuestions $moviequestions)
    {
        $this->moviequestions->destroy($moviequestions);

        return redirect()->route('admin.questions.moviequestions.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('questions::moviequestions.title.moviequestions')]));
    }
}
