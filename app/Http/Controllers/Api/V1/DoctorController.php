<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\SSOController;

class DoctorController extends Controller
{
    /**
     * doctor login with email and password
    */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [ 
            'email' => 'required', 
            'password' => 'required', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
		$data = [
			'email' => $request->email,
            'password' => $request->password 
		];
		if (auth()->attempt($data)) {
			$doctorInfo = auth()->user()->only(['id', 'name','email']);
			$response = SSOController::getTokenAndRefreshToken($request);
			$doctorInfo['tokenType'] = $response->token_type;
			$doctorInfo['accessToken'] = $response->access_token;
			$doctorInfo['refreshToken'] = $response->refresh_token;
			return response()->json(['success' => '1','message' => 'Doctor Login successfully','details' => $doctorInfo], 200);
        } else {
            return response()->json(['error' => 'Invalid Login Details! Please try agian'], 401);
        }
    }

    /**
     * Doctor logout api 
    */
    public function logout (Request $request) {
        $accessToken = Auth::user()->token();
        $token= $request->user()->tokens->find($accessToken);
        $token->revoke();
        return response()->json(['success' => '1','message' => 'You have been successfully logged out!'], 200);
    }

}
