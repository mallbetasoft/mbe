<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hospital; 
use App\Models\Specialitie;
use App\Models\BasicBillingSheet;
use Validator;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth; 
use Laravel\Passport\Client as OClient; 
use Illuminate\Support\Facades\Http;
use DB;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\LoginApiRequest;
use App\Http\Requests\BillingSheetApiRequest;






class ApisController extends Controller
{
    // doctor apis
	
	public function doctorLogin(Request $request){
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
			$response = $this->getTokenAndRefreshToken($request);
			$doctorInfo['tokenType'] = $response->token_type;
			$doctorInfo['accessToken'] = $response->access_token;
			$doctorInfo['refreshToken'] = $response->refresh_token;
			return response()->json(['success' => '1','message' => 'Doctor Login successfully','details' => $doctorInfo], 200);
        } else {
            return response()->json(['error' => 'Invalid Login Details! Please try agian'], 401);
        }
	}
	
	public function getTokenAndRefreshToken(Request $request){	
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
		$list = $instance->getContent();
        return json_decode($instance->getContent());
	}
	
	
	// Patient related apis (Advacne Section
	
	public function hospitalList(){
		$list = Hospital::select('id','hospital_name')->get();
		if($list){
			return response()->json(['success' => '1','message' => 'List found successfully','details' => $list], 200);
		}
		return response()->json(['error' => 'No List found'], 401);
	}
	
	public function specialityList(){
		$list = Specialitie::select('id','speciality_name')->get();
		if($list){
			return response()->json(['success' => '1','message' => 'List found successfully','details' => $list], 200);
		}
		return response()->json(['error' => 'No List found'], 401);
	}
	
	
	// Basic Billing Sheet
	
	public function uploadBillingSheet(BillingSheetApiRequest $request){
		$input['doctor_id'] = Auth::user()->id; 
		$input['comments'] = $request->comments ? $request->comments : '';
		$imageName = time().'.'.$request->billing_sheet_file->extension();
		$request->billing_sheet_file->move(public_path('basicBillingSheet'), $imageName);
		$input['billing_sheet_file'] = $imageName;
		$addBillingSheet = BasicBillingSheet::create($input);
		if($addBillingSheet){
			return response()->json(['success' => '1','message' => 'Billing Sheet uploaded successfully'],200);
		}
		return response()->json(['error' => 'Please try after some time'],401);
	}
}
