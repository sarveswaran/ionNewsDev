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
class CategoryController extends BasePublicController
{
    protected $guard;
    public function __construct(Response $response,Guard $guard,UserRepository $user,CategoryRepository $category)
    {
       parent::__construct();
       $this->response = $response;
       $this->guard = $guard;
       $this->user = $user;
       $this->category = $category;

    }
    public function categorylist(Request $request,Client $http){
    

            $categorylist = $this->category->getByAttributes(['status' => 1]);
            

            return $categorylist;

        }
  }