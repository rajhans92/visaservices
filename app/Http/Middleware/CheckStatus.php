<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        //If the status is not approved redirect to login
        if(Auth::check() && (Auth::user()->role_id == 3 || Auth::user()->role_id == 0)){
            Auth::logout();
            return redirect('/admin/login')->withErrors(['Only admin access.']);
        }
        if(Auth::check() && Auth::user()->status != 2){
            Auth::logout();
            return redirect('/admin/login')->withErrors(['This User is not active now. Please verify your email id.']);
        }

        return $response;
    }
}
