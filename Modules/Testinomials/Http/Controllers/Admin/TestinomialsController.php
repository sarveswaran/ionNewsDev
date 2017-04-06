<?php

namespace Modules\Testinomials\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Testinomials\Entities\Testinomials;
use Modules\Testinomials\Repositories\TestinomialsRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TestinomialsController extends AdminBaseController
{
    /**
     * @var TestinomialsRepository
     */
    private $testinomials;

    public function __construct(TestinomialsRepository $testinomials)
    {
        parent::__construct();

        $this->testinomials = $testinomials;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$testinomials = $this->testinomials->all();

        return view('testinomials::admin.testinomials.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('testinomials::admin.testinomials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->testinomials->create($request->all());

        return redirect()->route('admin.testinomials.testinomials.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('testinomials::testinomials.title.testinomials')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Testinomials $testinomials
     * @return Response
     */
    public function edit(Testinomials $testinomials)
    {
        return view('testinomials::admin.testinomials.edit', compact('testinomials'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Testinomials $testinomials
     * @param  Request $request
     * @return Response
     */
    public function update(Testinomials $testinomials, Request $request)
    {
        $this->testinomials->update($testinomials, $request->all());

        return redirect()->route('admin.testinomials.testinomials.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('testinomials::testinomials.title.testinomials')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Testinomials $testinomials
     * @return Response
     */
    public function destroy(Testinomials $testinomials)
    {
        $this->testinomials->destroy($testinomials);

        return redirect()->route('admin.testinomials.testinomials.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('testinomials::testinomials.title.testinomials')]));
    }
}
