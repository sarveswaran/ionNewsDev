<?php namespace Modules\Content\Http\Controllers\Api;


use Modules\Core\Http\Controllers\BasePublicController;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\User\Http\Requests\LoginRequest;
use Illuminate\Http\Response;
use Validator;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Modules\User\Repositories\UserRepository;
use Modules\User\Events\UserHasBegunResetProcess;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Services\UserResetter;
use Modules\Services\Repositories\UsertypeRepository;
use Modules\Authentication\Events\Confirmnotify;
use Modules\Content\Repositories\ContentRepository;
use Modules\Content\Repositories\CategoryRepository;
use Log;
class StoryController extends BasePublicController
{
    protected $guard;
    public function __construct(Response $response,Guard $guard,UserRepository $user,ContentRepository $content,CategoryRepository $category)
    {
       parent::__construct();
       $this->response = $response;
       $this->guard = $guard;
       $this->user = $user;
       $this->content = $content;
       $this->category = $category;
       //$this->middleware('auth:api');
      // $this->middleware('oauth');
    }
    public function story(Request $request,Client $http){
      $validator = Validator::make($request->all(), [
          'category_id' => 'required'
      ]);
      if ($validator->fails()) {
          $errors = $validator->errors();
          foreach ($errors->all() as $message) {
              $meserror =$message;
          }
          $this->response->setContent(array('message'=> $message));
        return $this->response->setStatusCode(400,$meserror);
      }else{

            $dataset = $this->content->findByAttributes(['category_id' => $request->category_id])->paginate(5);

            return $dataset;

        }
      }
     public function homepage(Request $request,Client $http){
            
            $categorylist = $this->category->getByAttributes(['status' => 1]);
            $dataresponse = array();
            foreach ($categorylist as $category) {
              $setexist = $this->content->findByAttributes(['category_id' => $category->id]);
              if(!empty($setexist)){
                $dataresponse[$category->name] = $this->content->getByAttributes(['category_id' => $category->id])->take(5);

              }else{
                   $dataresponse[$category->name] = array();
              } 
            }
            

            return $dataresponse;

        }
}