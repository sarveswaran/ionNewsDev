<?php

namespace Modules\Crawl\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Crawl\Entities\CrawlContent;
use Modules\Crawl\Repositories\CrawlContentRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CrawlContentController extends AdminBaseController
{
    /**
     * @var CrawlContentRepository
     */
    private $crawlcontent;

    public function __construct(CrawlContentRepository $crawlcontent)
    {
        parent::__construct();

        $this->crawlcontent = $crawlcontent;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$crawlcontents = $this->crawlcontent->all();

        return view('crawl::admin.crawlcontents.crawl', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('crawl::admin.crawlcontents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->crawl_page("http://www.sitename.com/",3);
        $this->crawlcontent->create($request->all());

        return redirect()->route('admin.crawl.crawlcontent.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('crawl::crawlcontents.title.crawlcontents')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CrawlContent $crawlcontent
     * @return Response
     */
    public function edit(CrawlContent $crawlcontent)
    {
        return view('crawl::admin.crawlcontents.edit', compact('crawlcontent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CrawlContent $crawlcontent
     * @param  Request $request
     * @return Response
     */

    public function crawl_page($url, $depth = 5){
        $seen = array();
        if(($depth == 0) or (in_array($url, $seen))){
            return;
        }   
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec ($ch);
        curl_close ($ch);
        if( $result ){
            $stripped_file = strip_tags($result, "<a>");
            preg_match_all("/<a[\s]+[^>]*?href[\s]?=[\s\"\']+"."(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/a>/", $stripped_file, $matches, PREG_SET_ORDER ); 
            foreach($matches as $match){
                $href = $match[1];
                    if (0 !== strpos($href, 'http')) {
                        $path = '/' . ltrim($href, '/');
                        if (extension_loaded('http')) {
                            $href = http_build_url($href , array('path' => $path));
                        } else {
                            $parts = parse_url($href);
                            $href = $parts['scheme'] . '://';
                            if (isset($parts['user']) && isset($parts['pass'])) {
                                $href .= $parts['user'] . ':' . $parts['pass'] . '@';
                            }
                            $href .= $parts['host'];
                            if (isset($parts['port'])) {
                                $href .= ':' . $parts['port'];
                            }
                            $href .= $path;
                        }
                    }
                    $this->crawl_page($href, $depth - 1);
                }
}   
        return $matches;
}

    public function update(CrawlContent $crawlcontent, Request $request)
    {
        $this->crawlcontent->update($crawlcontent, $request->all());

        return redirect()->route('admin.crawl.crawlcontent.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('crawl::crawlcontents.title.crawlcontents')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CrawlContent $crawlcontent
     * @return Response
     */
    public function destroy(CrawlContent $crawlcontent)
    {
        $this->crawlcontent->destroy($crawlcontent);

        return redirect()->route('admin.crawl.crawlcontent.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('crawl::crawlcontents.title.crawlcontents')]));
    }
}
