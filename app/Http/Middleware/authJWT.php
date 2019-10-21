<?php

namespace App\Http\Middleware;
use Closure;
use JWTAuth;
use Exception;
class authJWT
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::toUser($request->input('token'));
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status'=>100, 'message'=>'Token is Invalid', 'data' => NULL]);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status'=>100, 'message'=>'Token is Expired', 'data' => NULL]);
            }else{
                return response()->json(['status'=>100, 'message'=>'Something is wrong', 'data' => NULL]);
            }
        }
        return $next($request);
    }
}
