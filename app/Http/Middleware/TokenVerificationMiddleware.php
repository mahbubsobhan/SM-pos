<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\JWTToken;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('token');
        $result = JWTToken::verifyToken($token);
        if($result=="unauthorized"){
            return redirect('/userLogin');
        }else{
            //    বারবার ডেটাবেস থেকে তথ্য না নিয়ে হেডারের মাধ্যমে দ্রুত তথ্য পাওয়া যায়।
            $request->headers->set('email',$result->userEmail);
            $request->headers->set('id',$result->userID);
            return $next($request);
        }   
    }
}
