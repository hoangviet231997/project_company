<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use App\Exceptions\APIException;

class Validator
{
    public function handle($request, Closure $next, $name_model)
    {
        $model = app($name_model);
		$validator = app('validator')->make($request->input(), $model->rules($request), $model->messages());
		if ($validator->fails()) {
            throw new APIException($validator->errors(), 200);
        }
		return $next($request);
    }
}