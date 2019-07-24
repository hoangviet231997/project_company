<?php

namespace App\Http\Controllers\SystemApi;

use Response;
use Lang;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    public static function respond($_data="", $code_response = 200, $headers = [])
    {
        $data["status"] = $_data['status'];
        $data["data"] = $_data['data'];
        $data["msg"] = $_data['msg'];
        
        return Response::json($data, $code_response, $headers);
    }

    public static function respondError($msg = false, $_data = '{}', $code_response = 200, $headers = []) {
        $msg = $msg ? $msg : Lang::get('message.canNotFoundResource');
        
        $data["status"] = 'error';
        $data["data"] = $_data;
        $data["msg"] = $msg;
        
        return Response::json($data, $code_response, $headers);
    }        
}
