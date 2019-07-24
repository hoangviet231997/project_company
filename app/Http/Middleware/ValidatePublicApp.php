<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\v1\Controller;
use App\Models\app_identify;
use Closure;

class ValidatePublicApp
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
    	if(!app_identify::validateAccessToken($request->access_token, $request->send_datetime, $request->checksum)) {
    		return (new Controller())->respondInvalidAccessToken();
		}
        return $next($request);
    }
}
