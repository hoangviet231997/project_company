<?php

namespace App\Http\Controllers\SystemApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SystemModels\retail_system;
use Response;
use Lang;
use App\Http\Controllers\SystemApi\Controller as Respond;

class SystemApiController extends Controller
{
    public function login(){
    	if (isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] && $_POST['password'])
    	{
    		$username = $_POST['username'];
    		$password = $_POST['password'];
	        $query = retail_system::login($username, $password);

	        if($query)
	        {
	        	$data['status'] = "success";
	        	$data['data'] = $query;
	        	$data['msg'] = Lang::get('messages.success');
	        	return Respond::respond($data);
	        }
	        else
	        {
	        	$data['status'] = "error";
	        	$data['data'] = '{}'; 
	        	$data['msg'] = Lang::get('messages.login_fail');
	        	return Respond::respond($data);
	        }
	    }	  
    }
}
