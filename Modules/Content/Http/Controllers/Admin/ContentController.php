<?php

namespace Modules\Content\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Content\Entities\Content;
use Modules\Content\Repositories\ContentRepository;
use Modules\Content\Repositories\ContentUserRepository;
use Modules\Content\Repositories\MultipleCategoryContentRepository;
use Modules\Content\Repositories\CategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Repositories\UserRepository;
use Modules\User\Contracts\Authentication;

use Modules\User\Entities\Sentinel\User;
use Modules\Content\Entities\ContentImages;
use Modules\Content\Entities\ContentUser;
use Modules\Content\Entities\ContentCompany;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Modules\User\Repositories\RoleRepository;
use Log;
use DB;

class ContentController extends AdminBaseController
{
    /**
     * @var ContentRepository
     */
    private $content;

    public function __construct(ContentRepository $content,CategoryRepository $category,ContentUserRepository $contentUser , MultipleCategoryContentRepository $multiContCategory,RoleRepository $role)
    {
        parent::__construct();
        $this->category = $category;
        $this->content = $content;  
        $this->contentUser=$contentUser;
        $this->multiContCategory=$multiContCategory;
        $this->role=$role;
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
        $roles=json_decode($this->role->all());
          
          $user_roles[-1]['id']=-1;       
          $user_roles[-1]['type']='All';
             
         foreach ($roles as $value) { 
          if($value->name!='Admin')
          {                
          $user_roles[$value->id]['id']=$value->id;        
          $user_roles[$value->id]['type']=$value->name;
        
          }
         }  
            $user_roles[0]['id']=0;       
            $user_roles[0]['type']='default';
              
            // Log::info($user_roles); die;

        return view('content::admin.contents.create',compact('categories'),compact('user_roles'));
    }

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
        curl_close($ch);
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($result);
            if($dom->getElementsByTagName('title')->length>1){
            $title = $dom->getElementsByTagName('title')->item(0)->nodeValue;
            $sub_title = $dom->getElementsByTagName('title')->item(1)->nodeValue;
            }else {
             $title = $dom->getElementsByTagName('title')->item(0)->nodeValue;
             $sub_title = $title;
            }
              
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
                    else if ($a->name == 'src') {
                        $array[$i]['img_url'] = $a->nodeValue;

                    }
                    else if($a->name == 'width'){
                             if ($a->nodeValue != NULL)
                            $array[$i]['width'] = $a->nodeValue;
                    }
                    else if($a->name =='height'){
                             if ($a->nodeValue != NULL)
                            $array[$i]['height'] = $a->nodeValue;
                    }
                     else if($a->name =='border'){
                             if ($a->nodeValue != NULL)
                            $array[$i]['border'] = $a->nodeValue;
                    }

                }
                $i++;
            }
          
            $img_array = array();
            $img_url=array();
         
            foreach ($array as $value) {

                if(array_key_exists('height',$value) AND array_key_exists('width',$value)){
                if($value['height']>100 or $value['width']>100) {
                    $split_image = pathinfo($value['img_url']);
                    if (array_key_exists('img_name', $value)){ 

                    if(!in_array('gif', $split_image)){

                    if ($value['img_name'] != NULL){
                        $img_array[] = $value;
                         $img_url[]=$value['img_url'];
                    }
                    else  {
                          $value['img_name']='Sample_Image';
                          $img_array[] = $value;
                           $img_url[]=$value['img_url'];
                          }
                    }
                   }
                   else { 
                          if(!in_array('gif', $split_image)){
                              $value['img_name']='Sample_Image';
                              $img_array[] = $value;
                              $img_url[]=$value['img_url'];
                          }
                         }

                }
                }
            }
            if(sizeof($img_array)<5){                
            foreach ($array as $array_data) { 

                $split_image = pathinfo($array_data['img_url']);


                if(!in_array('gif', $split_image)){

                if (array_key_exists('img_name', $array_data)){

                    if ($array_data['img_name'] != NULL){
                        if (!in_array($array_data['img_url'], $img_url)) 
                        $img_array[] = $array_data;
                    }
                    else{
                          $array_data['img_name']='Sample_Image';
                          if (!in_array($array_data['img_url'], $img_url)) 
                          $img_array[] = $array_data;
                    }
                    }else{
                          $array_data['img_name']='Sample_Image';
                          if (!in_array($array_data['img_url'], $img_url)) 
                          $img_array[] = $array_data;
                    }

                   if(sizeof($img_array)==6)
                    break;
            }
            }           
            } 
           // echo "<pre>"; print_r($img_array);exit;
             
           
            $paragraph = $dom->getElementsByTagName('p');
            $paraarray = array();
            foreach ($paragraph as $pdata){
                $paraarray[] = $pdata->nodeValue;
            }
            $FinalArray = array();
            for ($i = 0; $i < sizeof($img_array); $i++){
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
        return $FinalArray;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        
        $Alldata=$request->all();
        if(!array_key_exists('image', $Alldata))
          $Alldata['image']=$Alldata['img1'];


        $sizeofCategories=sizeof($Alldata['category_id']);
        $multiContCategoryData=$Alldata['category_id'];

        $Alldata['all_category']=json_encode($Alldata['category_id']);
        $Alldata['category_id']=$sizeofCategories;      
        
      
        $ids=$this->content->create($Alldata);   
        
        $id=json_decode($ids,true);        
          $id=$ids['id'];
          if(sizeof($multiContCategoryData))
          {
             foreach ($multiContCategoryData as $value) {
                $abc['category_id']=$value;
                $abc['content_id']=$id;         

                $this->multiContCategory->create($abc); 
                
              }
          }
          

        if(array_key_exists('checkedDetails', $Alldata))
        {   
         $checkedArray=json_decode($Alldata['checkedDetails'][0],true);
            $length=sizeof($checkedArray); 

            for ($i=0;$i<$length;$i++) { 
          
                $abc['user_id']=$checkedArray[$i];
                $abc['content_id']=$id;
                $this->contentUser->create($abc);           
            }
        }


          $users =json_decode(User::all(),true);
          $company_name=array();
          $i=0;  
          $device_code=array();      
          foreach ($users as $key => $value) {
             if($value['id']==$Alldata['check'][$i])
                {
                    $company_name[]=$value['company'];
                    $i++;
                    $device_code[$value['id']]=$value['device_code'];

                }
                if($i>=sizeof($Alldata['check']))
                    break;
            }
          for ($i=0;$i<sizeof($company_name);$i++) {               
                 $ContentCompany= new ContentCompany;
                 $ContentCompany->content_id=$id;
                 $ContentCompany->company_name=$company_name[$i];
                 $ContentCompany->save();
            }
            $message=array();
            
             
            $message['title']=$Alldata['title'];
             $message['message']=$Alldata['content'];
            if(array_key_exists('image', $Alldata))
            $message['imageUrl']=$Alldata['image'];
            else $message['imageUrl']="";
            $message['crawl_url']=$Alldata['crawl_url'];

            Log::info($device_code);

     
            foreach ($device_code as $value) {
              if($value)
              $this->push_notifications($message,$value);
            }

           

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
     * @param  ContentUser $contentUser
     * @return Response
     */
    public function update(Content $content, Request $request,ContentUser $contentUser )
    { 
         $content_data=json_decode($content,true);
         $data=$request->all();

         $content_id=$content_data['id'];

         $sizeofCategories=sizeof($data['category_id']);
         $Allcategory=$data['category_id'];

         $data['all_category']=json_encode($data['category_id']);
         $data['category_id']=$sizeofCategories;      
        
         $categoryID=DB::table('content__multiplecategorycontents')                        
                          ->where('content_id','=',$content_id)->delete();
          // $categoryID=json_decode($categoryID,true);
          // $categoryIDs=array();
          // $k=0;

          // foreach ($categoryID as $value) {            
          //   $categoryIDs[$k++]=$value['category_id'];           
          // }
          foreach ($Allcategory as $value) {
             // if(!in_array($value, $categoryIDs))
             // {
              $abc['category_id']=$value;
              $abc['content_id']=$content_id;
              $this->multiContCategory->create($abc); 
            // }

            }


          if ($request->hasFile('img')){  
          $image_name=$content_id.$_FILES['img']['name'];
          $request->file('img')->move(env('IMG_URL').'/crawle_image',$image_name);
          $image=env('IMG_URL1').'/crawle_image/'.$image_name;   
           }
          else {
            $image = $content->image;
           } 
         
         $request->merge(['image' => $image]);
         $data['image']=$image;

         if(array_key_exists('check', $data))
         {  
              $userData = DB::table('content__contentusers')->select(\DB::raw('*'))
                ->where('content_id','=',$content_id)->get();
                $deleteId=array();
                $userData=json_decode($userData,true);

                 foreach ($userData as $key => $value) {
                                     
                      if(in_array($value['user_id'], $data['check']))
                         $deleteId[]=$value['user_id'];
                    
                }
                DB::table('content__contentusers')->where('content_id', '=', $content_id)
                ->whereNotIn('user_id',$deleteId)->delete();
               
                $length=sizeof($data['check']);
                for ($i=0;$i<$length;$i++) { 

                 if(!in_array($data['check'][$i], $deleteId)){

                        $abc['user_id']=$data['check'][$i];
                        $abc['content_id']=$content_id;
                        $this->contentUser->create($abc);                 

               }
            }  
                            
            

         }


        $this->content->update($content, $data);
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
    public function getAllUsers(Request $request)
    {   
            
        $users =json_decode(User::all(),true); 

         if (isset($_GET['id'])) {            
            $content_id=$_GET['id']; 
            $userData = DB::table('content__contentusers as cu')->select(\DB::raw('u.*'))
            ->join('users as u','u.id','=','cu.user_id')
            ->where('cu.content_id','=',$content_id)->get();
          $check_aray=array();
          $uncheck_array=array();
          $userData=json_decode($userData,true);
          $j=0;$k=0;
          $userId=array();
          foreach ($userData as $key => $value) {
               $userId[$key]=$value['id'];
          }
          $ch=0;
          foreach ($users as $value) {           
            if($ch<sizeof($userData) && in_array($value['id'], $userId))
            { 
                $check_array[$k]['id']=$value['id'];
                $check_array[$k]['name']=$value['first_name'];
                $check_array[$k]['role']=$value['designation'];
                $check_array[$k]['company']=$value['company'];

                $k++;
                $ch++;
            }
            else {
                 $uncheck_array[$j]['id']=$value['id'];
                 $uncheck_array[$j]['name']=$value['first_name'];
                 $uncheck_array[$j]['role']=$value['designation'];
                 $uncheck_array[$j]['company']=$value['company'];



                  $j++;

                 } 
                    
          }
         
          $FinalArray['check']=$check_array;
          $FinalArray['uncheck']=$uncheck_array;         
           }    
        else {              
              $company_name=array();
              $k=0;
              $FinalArray=array();
              foreach ($users as $value) {
              if($value['role'])
              {
              $FinalArray[$value['role']][$k]['id']=$value['id'];
              $FinalArray[$value['role']][$k]['name']=$value['first_name'];
              $FinalArray[$value['role']][$k]['role']=$value['designation'];
              $FinalArray[$value['role']][$k]['company']=$value['company'];
              }
              else {
              $FinalArray['default'][$k]['id']=$value['id'];
              $FinalArray['default'][$k]['name']=$value['first_name'];
              $FinalArray['default'][$k]['role']=$value['designation'];
              $FinalArray['default'][$k]['company']=$value['company'];

              }
              $k++;
              }
              Log::info($FinalArray);

     }
     return $FinalArray;
     }
     public function getAllUsersInfo(Request $request)
     {
          $users =json_decode(User::all(),true);
           $FinalArray_name=array();
           $FinalArray_ids=array();
           foreach ($users as $key => $value) {
                $name=$value['first_name']." ".$value['last_name'];
                $FinalArray_name[]=$name;
                $FinalArray_ids[$name]=$value['id'];
           }
             $FinalArray['name']=$FinalArray_name;
             $FinalArray['ids']=$FinalArray_ids;
           return response()->json($FinalArray);
     }

     public function store_user_info(Request $request)
     {      
          
           $content_id=$_GET['content_id'];
           $user_id=$_GET['user_id'];   
            // echo $content_id."   ".$user_id; exit;      

           $userData = DB::table('content__contentusers')->select(\DB::raw('*'))
            ->where('content_id','=',$content_id)->get();
            $userData=json_decode($userData,true);
            $check=0;
            foreach ($userData as $userInfo) {
                 if(in_array($user_id, $userInfo))
                      $check=1;             
                     
                } 
                    if($check==0)
                    {                     
                     $ContentUser= new ContentUser;
                     $ContentUser->user_id=$user_id;
                     $ContentUser->content_id=$content_id;
                     $ContentUser->save();
                     return 200;
                   } 
                    else return 202;           
      }

      public function push_notifications($msg = array(),$registrationIds)
      {
          $API_ACCESS_KEY = env("API_ACCESS_KEY");      
       
      
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
      public function push_notificationsIOS($smg=array(),$registrationIds)
      {

        $apnsHost = env('apnsHost');
        $apnsCert = env('apnsCert');
        $apnsPort = env('apnsPort');
        $apnsPass = env('apnsPass');
        $token =$registrationIds;
        
        // Log::info(json_encode($smg));
        // $message=json_encode($smg);
        // $payload['aps'] = array('alert' => 'Oh hai!','badge' => 1, 'sound' => 'default');
        // $payload['acme2']='ION NEWS';
        // $output = json_encode($payload);

        $story=$smg['message'];
        $story='IBM NEWS';
        $title='ION NEWS';
        $url="http://assets.jpg";

        $output='{
    "aps": { 
      "alert": { 
        "title": "Pusher Native Push Notifications API", 
        "subtitle": "Bringing you iOS 10 support!", 
        "body": "Now add more content to your Push Notifications!"
        }, 
        "mutable-content": 1,
        "category": "pusher"
      },
    "data": {
      "attachment-url": "https://pusher.com/static_logos/320x320.png"
    }
}';
        // Log::info($payload['acme2']=['abab','bababa']);
        // Log::info($output);
        // $token = pack('H*', str_replace(' ', '', $token));
        $apnsMessage = chr(0).chr(0).chr(32).$token.chr(0).chr(strlen($output)).$output;

        $streamContext = stream_context_create();
        stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
        stream_context_set_option($streamContext, 'ssl', 'passphrase', $apnsPass);

        $apns = stream_socket_client('ssl://'.$apnsHost.':'.$apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
        // print_r($apns);
        // Log::info($apns);

        if (!$apns)
         exit("Failed to connect: $err $errstr" . PHP_EOL);
        echo 'Connected to APNS' . PHP_EOL;

        fwrite($apns, $apnsMessage);
        fclose($apns);
        // echo "hahhaa";
      }

        public function deleteStory(Request $request)
        {
            $all_content=$request->data;
                  
            try{
            $data=DB::table('content__contents')
            ->whereIn('id',$all_content)->delete();
                } 
            catch(Exception $e) {
                  echo 'Message: ' .$e->getMessage();
                  }
            return response($data);        
        }       


}
