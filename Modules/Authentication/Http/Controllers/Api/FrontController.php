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
use Modules\User\Repositories\RoleRepository;
use Modules\User\Services\UserResetter;
use Modules\Services\Repositories\UsertypeRepository;
use Modules\Authentication\Events\Confirmnotify;
use Input;
use Log;
class FrontController extends BasePublicController
{
    protected $guard;
    public function __construct(Response $response,Guard $guard,UserRepository $user)
    {
       parent::__construct();
       $this->response = $response;
       $this->guard = $guard;
       $this->user = $user;
       //$this->middleware('auth:api');
      // $this->middleware('oauth');
    }
    public function login(Request $request,Client $http){
      $validator = Validator::make($request->all(), [
          'email' => 'required',
          'password' => 'required',

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
               if(isset($request->device_code))
               {
               if($request->device_code)
               Auth::User()->device_code=$request->device_code;
               }
              if(isset($request->device_type))
               {
               if($request->device_type)
               Auth::User()->device_type=$request->device_type;
               }
           
               Auth::user()->save();

               $token = Auth::generateTokenById($authicated_user->id);
               $authicated_user->token=$token;



                $authicated_user=json_decode($authicated_user,true);
               $response=array();
               $response['id']=$authicated_user['id'];
               $response['email']=$authicated_user['email'];
               $response['first_name']=$authicated_user['first_name'];
               $response['last_name']=$authicated_user['last_name'];
               $response['created_at']=$authicated_user['created_at'];
               $response['updated_at']=$authicated_user['updated_at'];
               $response['phone']=$authicated_user['phone'];
               $response['address']=$authicated_user['address'];
               $response['role']=$authicated_user['role'];
               $response['role_id']=$authicated_user['role_id'];

               if(!empty($authicated_user['device_code']))
               $response['device_code']=$authicated_user['device_code'];             
               else $response['device_code']="";

               if(!empty($authicated_user['company']))
               $response['company']=$authicated_user['company'];
               else $response['company']="";

               if(!empty($authicated_user['designation']))
               $response['designation']=$authicated_user['designation'];
               else $response['designation']="";
               $response['role']=$authicated_user['role'];
               if(!empty($authicated_user['profileImg']))
               $response['profileImg']=$authicated_user['profileImg'];
               else  $response['profileImg']="";
               
               $response['token']=$authicated_user['token'];


               return response(json_encode($response))->header('Content-Type', 'application/json');

               // return response($authicated_user);
               // return response(['id'=>$authicated_user->id,'token' => $token,'email'=>$authicated_user->email,'last_login' =>$last_login,'first_name'=> $authicated_user->first_name,'last_name'=>$authicated_user->last_name,'create_at'=>$authicated_user->created_at,'updated_at'=>$authicated_user->updated_at,
                // 'company_name'=>$authicated_user->company,'designation'=>$authicated_user->designation,'role'=>$authicated_user->role])->header('Content-Type', 'application/json');
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
      $authicated_user = Auth::user(); 
 
      if($authicated_user){
            return response($authicated_user)->header('Content-Type', 'application/json'); 
      }else{
           return $this->response->setStatusCode(401,'Invaid token');
      }
    }

    public function register(Request $request,RoleRepository $roles,Confirmnotify $confirm){
      
      $validator = Validator::make($request->all(), [
          'email' => 'required|unique:users',
          'password' => 'required',
          'first_name' => 'required|max:25',
          'role' => 'required',
          'last_name' => 'required|max:25',
          'device_code'=>'required',
          'role_id'=>'required'
      ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $meserror =$message;
            }
           $this->response->setContent(array('message'=> $message));
          return $this->response->setStatusCode(400,$meserror);
        }else{
  
          
            $role_id = '';
            $roledetails = $roles->all();
            Log::info($request->all()); 
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

            $user = $this->user->createWithRoles($request->all(), $role_id,true);
            $user->role = $request->role;

        $confirm->broadcastOn($user);
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {    
         $authicated_user = Auth::user();    
           if($this->user->find($authicated_user->id)->isActivated()){
               $last_login =  $authicated_user->last_login;
               Auth::user()->last_login = new \DateTime();
               Auth::user()->save();               
               $user->token = Auth::generateTokenById($authicated_user->id);
          return response($user)->header('Content-Type', 'application/json');
          }
        }
      }
    }

   public function update(Request $request){
        
          $validator = Validator::make($request->all(), [        
          'first_name' => 'required|max:25',
          'last_name' => 'required|max:25',
          'role' => 'required',
      ]);  
           
          if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {             

                $meserror =$message;
            }              
           $this->response->setContent(array('message'=> $message));
          return $this->response->setStatusCode(400,$meserror);
        }else { 
         

            $find_user = $this->user->find($request->user_id);

            if(isset($request->first_name) && $request->first_name){
                $first_name = $request->first_name;
            }else{
                $first_name = $find_user->first_name;
            }

            if(isset($request->last_name) && $request->last_name){
                $last_name = $request->last_name;
            }else{
                $last_name = $find_user->last_name;
            }

             if(isset($request->company) && $request->company){
                $company = $request->company;
            }else{
                $company = $find_user->company;
            }
           if(isset($request->designation) && $request->designation){
                $designation = $request->designation;
            }else{
                $designation = $find_user->designation;
            }





           
            $user_Detail = array(
                            'last_name' => $last_name,
                            'first_name' => $first_name,
                            'company'=>$company,
                            'designation'=>$designation
                          );
            $details = $this->user->update($find_user,$user_Detail);


            $response['id']=$details->id;
            $response['email']=$details->email;
            $response['first_name']=$details->first_name;
            $response['last_name']=$details->last_name;
            $response['created_at']=$details->created_at;
            $response['updated_at']=$details->updated_at;
            $response['phone']=$details->phone;
            $response['address']=$details->address;
            $response['role']=$details->role;
            $response['role_id']=$details->role_id;
            $response['status']=$details->status;
            $response['company']=$details->company;
            $response['designation']=$details->designation;
          
          return response($response)->header('Content-Type', 'application/json');
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
     public function updateuserinfo(Request $request){

     }
     public function updateProfileImg(Request $request)
     {
       Log::info($request->all());
       $validator = Validator::make($request->all(), [
          'profileImg' => 'required'
      ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $meserror =$message;
            }
            $this->response->setContent(array('message'=> $meserror));
          return $this->response->setStatusCode(400,$meserror);
        }else{    

                $find_user = $this->user->find($request->user_id);       

                $userId=$request->user_id;
                $data=$request->profileImg;
                $newname="profileImg".$userId.".jpg";  
                $imgurl = env('IMG_URL')."/".$newname;       
                $ifp = fopen($imgurl, "wb"); 
                fwrite($ifp, base64_decode($data)); 
                fclose($ifp); 
                $target1 = env('IMG_URL1')."/".$newname;

                $user_Detail = array(
                                    'profileImg' => $target1
                                    );
                $details = $this->user->update($find_user,$user_Detail);
               $response['profileImg']=$target1;
                // return response($target1);
                
                return response($response)->header('Content-Type', 'application/json');
             }


     }

     public function push_notifications(Request $request)
      {

        $apnsHost = env('apnsHost');
        $apnsCert = env('apnsCert');
        $apnsPort = env('apnsPort');
        $apnsPass = env('apnsPass');
        $token ='56ed3ac2a250158cc76c33af099a0629fb41a4565923154cb0675baa468b9915';    

        $story='IBM NEWS';
        $title='ION NEWS';
        $url="http://assets.myntassets.com.jpg";
//         $output='{
// "aps": {
// "alert": {
// "title": "123456789012345678901\n23456789012345766737373\n12345678901234",
// "body": "titi"
// }
// },
// "mediaUrl": "https://www.w3schools.com/html/pic_mountain.jpg",
// "mediaType": "image"}';


$output='{
"aps": {
"alert": {
"title":"IBM About IBM - United States",
"body": "Virginia M"
}
},
"mediaUrl": "http://www.ibm.com/ibm/us/en/res/innovation_food_safety_580x200.jpg",
"mediaType": "image"} ';

        // Log::info($payload['acme2']=['abab','bababa']);
        Log::info($output);
        $token = pack('H*', str_replace(' ', '', $token));
        $apnsMessage = chr(0).chr(0).chr(32).$token.chr(0).chr(strlen($output)).$output;

        $streamContext = stream_context_create();
        stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
        stream_context_set_option($streamContext, 'ssl', 'passphrase', $apnsPass);

        $apns = stream_socket_client('ssl://'.$apnsHost.':'.$apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
        // print_r($apns);
        Log::info($apns);

        if (!$apns)
         exit("Failed to connect: $err $errstr" . PHP_EOL);
        echo 'Connected to APNS' . PHP_EOL;

        fwrite($apns, $apnsMessage);
        fclose($apns);
         return response("successfully");





              $message['title']="https://www.google.co.in/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&ved=0ahUKEwibvueq74rUAhUJLY8KHcZOBaYQjRwIBw&url=https%3A%2F%2Fmadeby.google.com%2Fphone%2F&psig=AFQjCNF5QEC8J5piftgFBH2pcbASMTXfkw&ust=1495795695209453";
        $message['message']="https://www.google.co.in/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&ved=0ahUKEwibvueq74rUAhUJLY8KHcZOBaYQjRwIBw&url=https%3A%2F%2Fmadeby.google.com%2Fphone%2F&psig=AFQjCNF5QEC8J5piftgFBH2pcbASMTXfkw&ust=1495795695209453https://www.google.co.in/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&ved=0ahUKEwibvueq74rUAhUJLY8KHcZOBaYQjRwIBw&url=https%3A%2F%2Fmadeby.google.com%2Fphone%2F&psig=AFQjCNF5QEC8J5piftgFBH2pcbASMTXfkw&ust=1495795695209453https://www.google.co.in/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&ved=0ahUKEwibvueq74rUAhUJLY8KHcZOBaYQjRwIBw&url=https%3A%2F%2Fmadeby.google.com%2Fphone%2F&psig=AFQjCNF5QEC8J5piftgFBH2pcbASMTXfkw&ust=1495795695209453";
        $message['imageUrl']="https://www.google.co.in/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&ved=0ahUKEwibvueq74rUAhUJLY8KHcZOBaYQjRwIBw&url=https%3A%2F%2Fmadeby.google.com%2Fphone%2F&psig=AFQjCNF5QEC8J5piftgFBH2pcbASMTXfkw&ust=1495795695209453";
        $message['crawl_url']='http://git.mantralabsglobal.com/bharath/cms-project/blob/master/Modules/Content/Http/Controllers/Admin/ContentController.php';
        $device_code="d3hKcsfAkrE:APA91bFdXR__Y-hgLZW7XF3huDilsGfCBIk_A_Qn8P5ghzaz6h9isNpL15-iOAJ3Aiz5BGWtqr9OuMU_qv3iCuX-dan86yJn2mg96Q1TVM-EVgR-lWE2LkG6xsfGLcZIxAGnbMZGr2rz";

        $API_ACCESS_KEY = env("API_ACCESS_KEY");
        $registrationIds=$device_code;
        $msg=$message;      
       
      
        $fields = array
        (
          'registration_ids'  =>array($registrationIds),
          'data'      => $msg
        );
         
        $headers = array
        (
          'Authorization: key=' . $API_ACCESS_KEY,
          'Content-Type: application/json'
        );
        $url='https://fcm.googleapis.com/fcm/send';
         
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'http://android.googleapis.com/gcm/send');
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields) );
        $result = curl_exec($ch );       
        curl_close( $ch );
        // Log::info($result);
        return response($result);


      }
}