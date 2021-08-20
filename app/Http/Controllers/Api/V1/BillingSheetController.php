<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BasicBillingSheet;
use Illuminate\Support\Facades\Auth;  
use Illuminate\Support\Facades\Http;
use App\Http\Requests\Api\BillingSheetRequest;

class BillingSheetController extends Controller
{
    /**
     * upload billing sheet api 
    */
    public function billingSheetUpload(BillingSheetRequest $request){
        $input['billing_sheet_file'] = $this->fileUpload($request->file('billing_sheet_file'));
        $input['doctor_id'] = Auth::user()->id; 
		$input['comments'] = $request->comments ? $request->comments : '';
        $addBillingSheet = BasicBillingSheet::create($input);
		if($addBillingSheet){
			return response()->json(['success' => '1','message' => 'Billing Sheet uploaded successfully'],200);
		}
		return response()->json(['error' => 'Please try after some time'],401);
    }

    /**
     * get uploaded  billing sheets with doctor id
    */
    public function billingSheetList(){
        $doctorId = Auth::user()->id;
        $list = BasicBillingSheet::where('doctor_id' ,$doctorId)->orderBy('id','desc')->get();
        if(count($list) > 0){
            return response()->json(['success' => '1','message' => 'Billing Sheet List found successfully','details' => $list],200);
        }
		return response()->json(['error' => 'No list found'],401);
    }

    /**
     * delete single billing sheet with billing sheet id 
    */
    public function billingSheetDelete(BasicBillingSheet $id){
        $deleteFile = $id->delete();
        if($deleteFile){
            return response()->json(['success' => '1','message' => 'Billing Sheet deleted successfully'],200);
        }
        return response()->json(['error' => 'Please try after some time'],401);
    }

    /**
     * update billing sheet with billing id 
    */
    public function billingSheetUpdate(Request $request,BasicBillingSheet $id){
        if($request->hasFile('billing_sheet_file')){
            $updateBilling['billing_sheet_file'] = $this->fileUpload($request->file('billing_sheet_file'));
        }
        $updateBilling['comments'] = $request->comments ? $request->comments : '';
        $updateInfo = $id->update($updateBilling);
        if($updateInfo){
            return response()->json(['success' => '1','message' => 'Billing Sheet udpated successfully'],200);
        }
        return response()->json(['error' => 'Please try after some time'],401);
    }

    /**
     * common funciton for file upload 
    */
    public function fileUpload($fileName){
        $genrateFileName = time().'_'.$fileName->getClientOriginalName();
        $filePath = $fileName->storeAs('billingSheet', $genrateFileName, 'public');
        return $filePath;
    }


}
