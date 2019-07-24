<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\v1\Controller;
use App\Models\account;
use Closure;

class ValidateToken
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
    	if(!account::validateToken($request->token, $request->shop_id, $request->auth, $request->code)) {
    		return (new Controller())->respondInvalidToken();
		}
        return $next($request);
    }
}
