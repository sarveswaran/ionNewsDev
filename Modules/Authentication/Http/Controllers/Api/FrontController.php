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
use Modules\User\Events\UserHasBegunResetProcess;
use Modules\Contact\Repositories\User_DetailsRepository;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Services\UserResetter;
use Modules\Services\Repositories\UsertypeRepository;
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
          $this->response->setContent(array('message'=> $message));
        return $this->response->setStatusCode(400,$meserror);
      }else{

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
      
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {    
         $authicated_user = Auth::user();    
           if($this->user->find($authicated_user->id)->isActivated()){
               $last_login =  $authicated_user->last_login;
               Auth::user()->last_login = new \DateTime();
               Auth::user()->save();
               $token = Auth::generateTokenById($authicated_user->id);
               return response(['token' => $token,'last_login' =>$last_login,'role'=>$authicated_user->role])->header('Content-Type', 'application/json');
           }else{
               $this->response->setContent(array('message'=>'Please Activate your account'));
               return $this->response->setStatusCode(401,'Please Activate your account');
           }
         }
       }
        $this->response->setContent(array('message'=>'Email or Password is invalid'));
        return $this->response->setStatusCode(401,'Email or Password is invalid');
    }

    public function forgotpassword(Request $request){
        $validator = Validator::make($request->all(), [
          'email' => 'required|unique:users'
          ]);
        if ($validator->fails()) {
          if(isset($request->email) && $request->email){
            $user = $this->user->findByCredentials(['email' => $request->email ]);
            app(UserResetter::class)->startReset($request->all());
            //return $user;
           // event(new UserHasBegunResetProcess($user,rand()));
            return  array('message' => "successfully sent" );
          }else{
               $this->response->setContent(array('message'=>'Email id required'));
              return $this->response->setStatusCode(400,'Email id required');
          }     
        }else{
              $this->response->setContent(array('message'=>'Email id not Exists'));
            return $this->response->setStatusCode(400,'Email id not Exists');
        }
      }

    public function userDetails(Request $request){
      //Auth::setToken($request->header('Authorization'));   
      $authicated_user = Auth::user(); 
      $user_details = $this->user_details->findByAttributes(['user_id' => $authicated_user->id]);
      $user_details['email'] = $authicated_user->email;
      $user_details['first_name'] = $authicated_user->first_name;
      $user_details['last_name'] = $authicated_user->last_name;
      $user_details['role'] = $authicated_user->role;

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
          'phone' => 'required|unique:contact__user_details',
          'first_name' => 'required',
          'role' => 'required',
          'last_name' => 'required'
      ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $meserror =$message;
            }
           $this->response->setContent(array('message'=> $message));
          return $this->response->setStatusCode(400,$meserror);
        }else{
  
            if(isset($request->license_copy) && $request->license_copy){
              $imageData = base64_decode($request->license_copy); 
              $photo = imagecreatefromstring($imageData); // <-- **Change is here**
              $time_upload = time(); 
              $name = 'image_'.$request->license_number.'_'.$time_upload.'.jpg';
              $path = 'assets/media/'.$name;
              imagejpeg($photo,$path,100);
            }else{
              $path = 'null';
            }

            if(isset($request->photo) && $request->photo){
              $imagepro = base64_decode($request->photo); 
              $prophoto = imagecreatefromstring($imagepro); // <-- **Change is here**
              $proname = 'image_'.$request->first_name.'_'.$time_upload.'.jpg';
              $propath = 'assets/media/'.$proname;
              imagejpeg($prophoto,$propath,100);
            }else{
              $propath = 'assets/media/profile.jpg';
            }
            $role_id = '';
            $roledetails = $roles->all();
            foreach ($roledetails as $roledetail) {
                if(ucfirst($request->role) != 'Admin'){
                  if(ucfirst($request->role) == ucfirst($roledetail->name)){
                      $role_id = $roledetail->id;
                  }
                }else{
                  return $this->response->setStatusCode(400,'Not allowed as admin'); 
                }
            }
            if(!$role_id){
               return $this->response->setStatusCode(400,'Not allowed as Usertype');
            }

            if(isset($request->address) && $request->address){
                $address = $request->address;
            }else{
                $address = '';
            }

            if(isset($request->shop_name) && $request->shop_name){
                $shop_name = $request->shop_name;
            }else{
                $shop_name = '';
            }

            $user = $this->user->createWithRoles($request->all(), $role_id);
            $user = json_decode($user, true);
            $user_Detail = array('user_id' => $user['id'],
                            'phone' => $request->phone,
                            'shop_name'  =>  $shop_name,
                            'address' => $address
                            );
           $details = $this->user_details->create($user_Detail);
          return response($details)->header('Content-Type', 'application/json');
      }
    }

    public function updateuserinfo(Request $request){
      $validator = Validator::make($request->all(), [
          'license_number' => 'required',
          'license_copy' => 'required',
          'license_expire' => 'required'
      ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $meserror =$message;
            }
            $this->response->setContent(array('message'=> $message));
          return $this->response->setStatusCode(400,$meserror);
        }else{
            $imageData = base64_decode($request->license_copy); 
            $photo = imagecreatefromstring($imageData); // <-- **Change is here**
            $time_upload = time(); 
            $name = 'image_'.$request->license_number.'_'.$time_upload.'.jpg';
            $path = 'assets/media/'.$name;
            imagejpeg($photo,$path,100);

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

           $shop_image = '';
           $shop_name = '';

           if(ucfirst($request->role) == 'Dispensary'){

              if(isset($request->shop_name) && $request->shop_name){
                $shop_name = $request->shop_name;
              }else{
                  $this->response->setContent(array('message'=> 'Shop name required'));
                 return $this->response->setStatusCode(400,'Shop name required');
              }

              if(isset($request->shop_image) && $request->shop_image){
                $shop_image = $request->shop_image;
              }else{
                $shop_image = '';
              }

            }

            if(isset($request->description) && $request->description){
                $description = $request->description;
            }else{
                $description = '';
            }

            $user_Detail = array(
                            'license_number' => $request->license_number,
                            'license_copy' => $path,
                            'photo' => $propath,
                            'license_expire' => $request->license_expire,
                            'shop_name' => $shop_name,
                            'shop_image' => $shop_image,
                            'description' => $description
                            );
           $find_user = $this->user_details->findByAttributes(array('user_id'=>$request->user_id));
           $details = $this->user_details->update($find_user,$user_Detail);
          return response($details)->header('Content-Type', 'application/json');
      }
    }

    public function update(Request $request){
            
            $find_user = $this->user_details->findByAttributes(array('user_id'=>$request->user_id));

            if(isset($request->license_copy) && $request->license_copy){
                $imageData = base64_decode($request->license_copy); 
                $photo = imagecreatefromstring($imageData); // <-- **Change is here**
                $time_upload = time(); 
                $name = 'image_'.$request->license_number.'_'.$time_upload.'.jpg';
                $path = 'assets/media/'.$name;
                imagejpeg($photo,$path,100);
            }else{
                $path = $find_user->license_copy;
            }
            
            if(isset($request->photo) && $request->photo){
              $imagepro = base64_decode($request->photo); 
              $time_upload = time();
              $prophoto = imagecreatefromstring($imagepro); // <-- **Change is here**
              $proname = 'image_'.$request->first_name.'_'.$time_upload.'.jpg';
              $propath = 'assets/media/'.$proname;
              imagejpeg($prophoto,$propath,100);
            }else{
              $propath = $find_user->photo;
            }

           $shop_image = '';
           $shop_name = '';

           if(ucfirst($request->role) == 'Dispensary'){

              if(isset($request->shop_name) && $request->shop_name){
                $shop_name = $request->shop_name;
              }else{
                $shop_name = $find_user->shop_name; 
              }

              if(isset($request->shop_image) && $request->shop_image){
                $shopimageData = base64_decode($request->shop_image); 
                $shopphoto = imagecreatefromstring($shopimageData); // <-- **Change is here**
                $time_upload = time(); 
                $shopimgname = 'image_'.$time_upload.'.jpg';
                $shop_image = 'assets/media/'.$shopimgname;
                imagejpeg($shopphoto,$shop_image,100);
              }else{
                $shop_image = $find_user->shop_image;
              }

            }

            if(isset($request->latitude) && $request->latitude){
                $latitude = $request->latitude;
            }else{
                $latitude = $find_user->latitude; 
            }

            if(isset($request->longitude) && $request->longitude){
                $longitude = $request->longitude;
            }else{
                $longitude = $find_user->longitude; 
            }

            if(isset($request->description) && $request->description){
                $description = $request->description;
            }else{
                $description = $find_user->description;
            }

            if(isset($request->phone) && $request->phone){
                $phone = $request->phone;
            }else{
                $phone = $find_user->phone;
            }

            if(isset($request->address) && $request->address){
                $address = $request->address;
            }else{
                $address = $find_user->address;
            }

            if(isset($request->address2) && $request->address2){
                $address2 = $request->address2;
            }else{
                $address2 = $find_user->address2;
            }

            if(isset($request->state) && $request->state){
                $state = $request->state;
            }else{
                $state = $find_user->state;
            }

            if(isset($request->city) && $request->city){
                $city = $request->city;
            }else{
                $city = $find_user->city;
            }

            if(isset($request->pincode) && $request->pincode){
                $pincode = $request->pincode;
            }else{
                $pincode = $find_user->pincode;
            }

            if(isset($request->country) && $request->country){
                $country = $request->country;
            }else{
                $country = $find_user->country;
            }

            $user_Detail = array(
                            'license_number' => $request->license_number,
                            'license_copy' => $path,
                            'longitude'  => $longitude,
                            'latitude'  => $latitude,
                            'address'  => $address,
                            'address2' => $address2,
                            'pincode' => $pincode,
                            'city' => $city,
                            'state' => $state,
                            'country' => $country,
                            'photo' => $propath,
                            'phone' => $phone,
                            'license_expire' => $request->license_expire,
                            'shop_name' => $shop_name,
                            'shop_image' => $shop_image,
                            'description' => $description
                          );
           
           $details = $this->user_details->update($find_user,$user_Detail);
          return response($details)->header('Content-Type', 'application/json');
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
          return $this->response->setStatusCode(400,$meserror);
        }else{
          if ($this->auth->activate($request->userId, $request->code)) {
               $this->response->setContent(array('message'=> 'verified successfully'));
             return $this->response->setStatusCode(200,'verified successfully');
          }else{
              if($this->user->find($request->userId)->isActivated()){
                   $this->response->setContent(array('message'=>'Already Activated please Login'));
                return $this->response->setStatusCode(400,'Already Activated please Login');
              }else{
                  $this->response->setContent(array('message'=> 'User id or activation code not correct'));
                return $this->response->setStatusCode(400,'there was an error with the activation');
              }
          }
        }
     }
      public function resetpassword(Request $request){
      $validator = Validator::make($request->all(), [
          'userId' => 'required|exists:users,id',
          'code' => 'required',
          'password' => 'required|min:3|confirmed',
          'password_confirmation' => 'required',
      ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $meserror =$message;
            }
            $this->response->setContent(array('message'=> $meserror));
          return $this->response->setStatusCode(400,$meserror);
        }else{
          try {
            app(UserResetter::class)->finishReset(
                array_merge($request->all(), ['userId' => $request->userId, 'code' => $request->code])
            );
            } catch (UserNotFoundException $e) {
                return array('message' => 'invalid code');
            } catch (InvalidOrExpiredResetCode $e) {
                return array('message' => 'invalide user or code');
            }
          return array('message' => 'successfully updated');
        }
     }
     
     public function usertypes(Request $request,UsertypeRepository $role){
        $userroles =  $role->getByAttributes(['status' => 1]);
         foreach ($userroles as $userrole) {
           $userrole->role;
         }
         $userTypes = array();
         foreach ($userroles as $usertype) {
           array_push($userTypes, ['role_id' => $usertype->role_id,'name' => $usertype->role['name']]);
         }
        return $userTypes;
     }
}