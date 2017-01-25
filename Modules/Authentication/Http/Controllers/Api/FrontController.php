<?php namespace Modules\Authentication\Http\Controllers\Api;


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
use Modules\Contact\Repositories\User_DetailsRepository;
use Modules\User\Repositories\RoleRepository;
use Log;
class FrontController extends BasePublicController
{
    protected $guard;
    public function __construct(Response $response,Guard $guard,UserRepository $user,
      User_DetailsRepository $user_Details)
    {
    	 parent::__construct();
    	 $this->response = $response;
       $this->guard = $guard;
       $this->user = $user;
       $this->user_details = $user_Details;
       //$this->middleware('auth:api');
      // $this->middleware('oauth');
    }
    public function login(Request $request,Client $http){
      $validator = Validator::make($request->all(), [
          'email' => 'required',
          'password' => 'required'
      ]);
      if ($validator->fails()) {
          $errors = $validator->errors();
          foreach ($errors->all() as $message) {
              $meserror =$message;
          }
           $this->response->setContent(array('message'=>$meserror));
        return $this->response->setStatusCode(400,$meserror);
      }else{

      	$credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
      
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {    
         $authicated_user = Auth::user();    
           if($this->user->find($authicated_user->id)->isActivated() && ucfirst($authicated_user->role) == ucfirst('user') && $authicated_user->status == 1){
               $last_login =  $authicated_user->last_login;
               Auth::user()->last_login = new \DateTime();
               Auth::user()->save();
               $token = Auth::generateTokenById($authicated_user->id);
             return response(['token' => $token,'last_login' =>$last_login])->header('Content-Type', 'application/json');
           }else{
               $this->response->setContent(array('message'=>'Please Activate your account'));
               return $this->response->setStatusCode(401,'Please Activate your account');
           }
         }
       }
        $this->response->setContent(array('message'=>'Email or Password is invalid'));
        return $this->response->setStatusCode(401,'Email or Password is invalid');
    }

    public function userDetails(Request $request){
      //Auth::setToken($request->header('Authorization'));   
      $authicated_user = Auth::user(); 
      $user_details = $this->user_details->findByAttributes(['user_id' => $authicated_user->id]);
      $user_details['email'] = $authicated_user->email;
      $user_details['first_name'] = $authicated_user->first_name;
      $user_details['last_name'] = $authicated_user->last_name;
      $user_details['mobile'] = $authicated_user->phone;
      $user_details->location;
      if($authicated_user){
           return response($user_details)->header('Content-Type', 'application/json'); 
      }else{
           return $this->response->setStatusCode(401,'Invaid token');
      }
    }
    public function register(Request $request,RoleRepository $roles){
      $validator = Validator::make($request->all(), [
          'email' => 'required|unique:users',
          'password' => 'required',
          'phone' => 'required|unique:users|max:10|min:10',
          'location_id' => 'required',
          'first_name' => 'required'
      ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $meserror =$message;
            }
            $this->response->setContent(array('message'=>$meserror));
          return $this->response->setStatusCode(400,$meserror);
        }else{
            

            if(isset($request->photo) && $request->photo){
              $imagepro = base64_decode($request->photo); 
              $time_upload = time(); 
              $prophoto = imagecreatefromstring($imagepro); // <-- **Change is here**
              $proname = 'image_'.$request->first_name.'_'.$time_upload.'.jpg';
              $propath = 'assets/media/'.$proname;
              imagejpeg($prophoto,$propath,100);
            }else{
              $propath = 'assets/media/profile.jpg';
            }
            $role_id = '';
            $role_type = $roles->findByName(['name' => 'user']);
            if(isset($role_type->name)){

              $request->merge(array('role' => $role_type->name));
              $role_id = $role_type->id;

            }else{
               return $this->response->setStatusCode(401,'Not allowed as Usertype');
            }

            if(isset($request->last_name) && $request->last_name){
              $last_name = $request->last_name;
            }else{
               $last_name = '';
            }
            $request->merge(array('last_name' => $last_name));
            $user = $this->user->createWithRoles($request->all(), $role_id , true);
            $user = json_decode($user, true);
            $user_Detail = array('user_id' => $user['id'],
                            'phone' => $request->phone,
                            'location_id' =>  $request->location_id,
                            'status' => 0
                            );
           $details = $this->user_details->create($user_Detail);
          return response($details)->header('Content-Type', 'application/json');
      }
    }
    public function updateuserinfo(Request $request){
      
         $find_user = $this->user_details->findByAttributes(array('user_id'=>$request->user_id));
         $existuser = $this->user->find($request->user_id);
         if(isset($find_user->id)){
           
            if(isset($request->flat_number) && $request->flat_number){
                $flat_number =  $request->flat_number;
            }else{
                $flat_number =  $find_user->flat_number;
            }

            if(isset($request->block_name) && $request->block_name){
                $block_name =  $request->block_name;
            }else{
                $block_name =  $find_user->block_name;
            }

            if(isset($request->first_name) && $request->first_name){
                $first_name =  $request->first_name;
            }else{
                $first_name =  $existuser->first_name;
            }

            if(isset($request->last_name) && $request->last_name){
                $last_name =  $request->last_name;
            }else{
                $last_name =  $existuser->last_name;
            }

            $user_Detail = array(
                            'flat_number' => $flat_number,
                            'block_name' => $block_name
                            );
            $user_auth  = array('first_name' => $first_name,
                            'last_name' => $last_name);

           $userupdate = $this->user->update($existuser,$user_auth);
           $details = $this->user_details->update($find_user,$user_Detail);
           $userupdate->details = $details;
          return response($userupdate)->header('Content-Type', 'application/json');
        }
    }
    public function getactive(Request $request){
      $validator = Validator::make($request->all(), [
          'userId' => 'required|exists:users,id',
          'code' => 'required'
      ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $meserror =$message;
            }
            $this->response->setContent(array('message'=> $meserror));
          return $this->response->setStatusCode(401,$meserror);
        }else{
          if ($this->auth->activate($request->userId, $request->code)) {
               $this->response->setContent(array('message'=> 'verified successfully'));
             return $this->response->setStatusCode(200,'verified successfully');
          }else{
              if($this->user->find($request->userId)->isActivated()){
                   $this->response->setContent(array('message'=>'Already Activated please Login'));
                return $this->response->setStatusCode(401,'Already Activated please Login');
              }else{
                  $this->response->setContent(array('message'=> 'User id or activation code not correct'));
                return $this->response->setStatusCode(401,'there was an error with the activation');
              }
          }
        }
    }

    public function registerfamily(Request $request,RoleRepository $roles){
      $validator = Validator::make($request->all(), [
          'email' => 'required|unique:users',
          'phone' => 'required|unique:users|max:10|min:10',
          'first_name' => 'required'
      ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $meserror =$message;
            }
          return $this->response->setStatusCode(400,$meserror);
        }else{
            $role_id = '';
            $role_type = $roles->findByName(['name' => 'user']);
            if(isset($role_type->name)){

              $request->merge(array('role' => $role_type->name));
              $role_id = $role_type->id;

            }else{
               return $this->response->setStatusCode(400,'Not allowed as Usertype');
            }

            $request->merge(array('password' => 1234));

            $request->merge(array('parent_id' => $request->user_id));
            if(isset($request->last_name) && $request->last_name){
              $last_name = $request->last_name;
            }else{
               $last_name = '';
            }
            $request->merge(array('last_name' => $last_name));
            $user = $this->user->createWithRoles($request->all(), $role_id , true);
          return response($user)->header('Content-Type', 'application/json');
      }
    }
    public function removemember(Request $request){
        $validator = Validator::make($request->all(), [
          'id' => 'required|exists:users'
      ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $meserror =$message;
            }
          return $this->response->setStatusCode(400,$meserror);
        }else{
          $userfamily =   $this->user_details->findByfield($request->id ,$request->user_id);
          if(isset($userfamily->id)){
            $this->user->delete($userfamily->id);
             return "Member removed successfully";
          }else{
              return "Member Not found";
          }
       }
    }
    public function members(Request $request){
        $userfamily =   $this->user_details->userparent($request->user_id);
        return $userfamily;
    }
}