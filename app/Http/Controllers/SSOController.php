<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth; 
use Laravel\Passport\Client as OClient; 
use Illuminate\Support\Facades\Http;
use DB;
use Illuminate\Support\Facades\Route;

class SSOController extends Controller
{
	/**
	* generate access token and refresh token 
	*/
    static function getTokenAndRefreshToken(Request $request){	
		$oClient = OClient::where('password_client', 1)->first();
		$request->request->add([
			'grant_type' => 'password',
			'client_id' => $oClient->id,
			'client_secret' => $oClient->secret,
			'username' => $request->email,
			'password' => $request->password,
        ]);
        $tokenRequest = $request->create(
			env('APP_URL').'/oauth/token',
			'post'
        );
        $instance = Route::dispatch($tokenRequest);
        return json_decode($instance->getContent());
	}

	/**
	 * get access token with refresh token
	*/
	public function refreshToken(Request $request){
		$refresh_token = $request->refreshToken ? $request->refreshToken:'';
		if(!$refresh_token){
			return json_encode(['message' => 'refresh_token is required']);
		}
		$oClient = OClient::where('password_client', 1)->first();
		if(!$oClient){
			return json_encode(['message' => 'Invalid client id and secret id']);
		}
		$request->request->add([
			'grant_type' => 'refresh_token',
			'refresh_token' => $refresh_token,
			'client_id' => $oClient->id,
			'client_secret' => $oClient->secret,
		]);
		$tokenRequest = $request->create(
			env('APP_URL').'/oauth/token',
			'post'
		);
		$instance = Route::dispatch($tokenRequest);
		return json_decode($instance->getContent());
	}
}
