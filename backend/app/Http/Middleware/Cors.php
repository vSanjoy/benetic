<?php 
namespace App\Http\Middleware;
use Closure;

use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Applicaion;

class Cors {

 	/**
  	* Handle an incoming request.
  	*
  	* @param \Illuminate\Http\Request $request
  	* @param \Closure $next
  	* @return mixed
  	*/
 	public function handle($request, Closure $next)
 	{
 		$response = $next($request);
		$response->headers->set('Access-Control-Allow-Origin' , '*');
		$response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PATCH, PUT, DELETE, OPTIONS');
		$response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token, Accept, Authorization, X-Requested-With, Application,access-token, reset-token,validate-token, tokenid, x-access-token');
		return $response;
 	}
 
}