<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\v1\Controller;
use Closure;
use App\Models\customer_supplier;

class ValidateUserToken
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
    	if(!customer_supplier::validateUserToken($request->token)) {
    		return (new Controller())->respondInvalidToken();
		}
        return $next($request);
    }
}
