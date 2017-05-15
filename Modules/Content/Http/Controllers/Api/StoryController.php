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
use Modules\Content\Repositories\ContentLikeStoryRepository;
use Modules\Content\Entities\ContentLikeStory;
use Modules\Content\Repositories\MultipleCategoryContentRepository;
use Log;
use DB;

class StoryController extends BasePublicController
{
    protected $guard;
    public function __construct(Response $response,Guard $guard,UserRepository $user,ContentRepository $content,CategoryRepository $category,ContentLikeStoryRepository $likestory, MultipleCategoryContentRepository $multiContCategory)
    {
       parent::__construct();
       $this->response = $response;
       $this->guard = $guard;
       $this->user = $user;
       $this->content = $content;
       $this->category = $category;
       $this->likestory=$likestory;
       $this->multiContCategory=$multiContCategory;
       //$this->middleware('auth:api');
      // $this->middleware('oauth');
    }
    public function story(Request $request,Client $http){
      $validator = Validator::make($request->all(), [
          'category_id' => 'required'
      ]);
       
      $user_id=$request->user_id;
      if ($validator->fails()) {
          $errors = $validator->errors();
          foreach ($errors->all() as $message) {
              $meserror =$message;
          }
          $this->response->setContent(array('message'=> $message));
        return $this->response->setStatusCode(400,$meserror);
      }else{
            $dataset = $this->content->filter( $request->category_id,$user_id);
            foreach ($dataset as $key => $value) {    
                unset($value->category_id);
               $value->like_count=$this->likestory->checkLikeorNot($value,$user_id);
               if($value->like_count)
               $value->islike=1;
               else $value->islike=0;               
            }          
            return $dataset;
        }
      }
     
     public function homepage(Request $request,Client $http){       
            
            $categorylist = $this->category->getByAttributes(['status' => 1],'priority');
            $dataresponse = array();
            $current_date=date('Y-m-d');
            $user_id=$request->user_id;       

            foreach ($categorylist as $category) {
               $setexist=$this->content->getStoryByCategory($category->id,$user_id);
            
                            
                                                     
              if(!empty($setexist)){
                 $response=$setexist;
                if(count($response)!=0)
                {     
                 foreach ($response as $key => $value) {

                                $value->priority=$category->priority;
                                // $value->like_count=$this->checkLikeorNot($value,$user_id);
                              
                            }           
                 $dataresponse[$category->name]=$response;  
                 }          
                
                            

              }else{
                     $priority['priority']=1;
                   $dataresponse[$category->name] =$priority; 
                   
              } 
            }
             // Log::info(json_encode($dataresponse));

            Log::info(response($dataresponse));
            
            return response($dataresponse);

        }

        public function story_like(Request $request)
        { 
                 $validator = Validator::make($request->all(), [
                 'content_id' => 'required']);
       
                 
                   if ($validator->fails()) {
                    $errors = $validator->errors();
                    foreach ($errors->all() as $message) {
                        $meserror =$message;
                    }
                    $this->response->setContent(array('message'=> $message));
                    return $this->response->setStatusCode(400,$meserror);
                  }else{
                         
                    $user_id=$request->user_id;  
                   $content_id=$request->content_id;       
                   $data=DB::table('content__contentlikestories')
                              ->where('content_id','=',$content_id)
                               ->where('user_id','=',$user_id)
                               ->get();

                   if(sizeof($data)>0)
                   { 
                    $data=DB::table('content__contentlikestories')
                        ->where('content_id','=',$content_id)
                        ->where('user_id','=',$user_id)
                        ->delete();

                   }
                  else {
                           
                    $abc['user_id']=$user_id;
                    $abc['content_id']=$content_id;
                    $data=$this->likestory->create($abc); 
                    }
                    $response['status']="successful";
              return response($response);
        }
        }
        public function getAllLikeStory(Request $request)
        { 
           $current_date=date('Y-m-d');      
          $dataset=DB::table('content__contents as cc')
                  ->join('content__contentlikestories as ccl', 'cc.id','=','ccl.content_id')
                   ->select('cc.*' )
                   ->where('cc.expiry_date','>=',$current_date)
                   ->where('ccl.user_id','=',$request->user_id)                        
                   ->paginate(12);
                 foreach ($dataset as $key => $value) {             
                   $value->islike=1;
               
                  }              
                  return response($dataset);

        }
}