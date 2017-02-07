<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Log;


class OauthAuthentication
{

    /**
     * The URIs that should be excluded from token verification
     *
     * @var array
     */
    protected $except = ['/api/questions'];

    /**
     * Handle an incoming request.

     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function __construct(Client $client){
        $this->client =$client;
    }
    public function handle($request, Closure $next, $guard = null)
    {

        if(!$request->header('Authorization')){
            return response('token not found',401);
        }else{
            Auth::setToken($request->header('Authorization'));   
            $authicated_user = Auth::user(); 

            if($authicated_user){
                $request->merge(array('user_id' => $authicated_user->id));
            }else{
                if ($this->shouldPassThrough($request)) {
                    return $next($request);
                }
                return response('invalid token',401);
            }                
            return $next($request);
       }
    }

    protected function shouldPassThrough($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
