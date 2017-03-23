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
//    public function createImg()
//    {
//
//    }


    public function ajaxcall(Request $request)
    {
        $url=$_GET['url'];
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($ch);

            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);

            $dom->loadHTML($result);
            $title = $dom->getElementsByTagName('title')->item(0)->nodeValue;
        if(strpos($result,"<img")>0) {
            $img = $dom->getElementsByTagName('img');
            $i = 0;
            $array = array();
            foreach ($img as $value) {
                $aa = $value->attributes;
                foreach ($aa as $a) {
                    if ($a->name == 'alt') {
                        if ($a->nodeValue != NULL)
                            $array[$i]['img_name'] = $a->nodeValue;
                    }
                    if ($a->name == 'src') {
                        $array[$i]['img_url'] = $a->nodeValue;

                    }
                }
                $i++;
            }

            $img_array = array();
            foreach ($array as $array_data) {
                if (array_key_exists('img_name', $array_data))
                    if ($array_data['img_name'] != NULL)
                        $img_array[] = $array_data;
            }

            $paragraph = $dom->getElementsByTagName('p');

            $paraarray = array();
            foreach ($paragraph as $pdata) {
                $paraarray[] = $pdata->nodeValue;
            }
            $FinalArray = array();
            for ($i = 0; $i < sizeof($img_array); $i++) {
                $FinalArray[$i]['img_name'] = $img_array[$i]['img_name'];
                $FinalArray[$i]['img_url'] = $img_array[$i]['img_url'];
                if ($i < sizeof($paraarray))
                    $FinalArray[$i]['desc'] = $paraarray[$i];
            }
            $count = sizeof($FinalArray);
            $FinalArray['title'] = $title;
            $FinalArray['sub_title'] = $title;
            $FinalArray['count'] = $count;
            $FinalArray['status']=200;
        }else{  $FinalArray['title'] = $title;
                $FinalArray['status']=202;
            }
//        $imageUrl = 'http://www.samsung.com/in/common/img/home/S2_pc.png';
//        $img_path="scrollimg/S2_pc.png";


        return $FinalArray;
//        return array('title' => $title,'sub_title' => 'sports  best person in the world','content' => 'm,sdm, dsd,msndmsds dssddsd sdddsds dsd');
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
        //print_r($request->chk);die;
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
