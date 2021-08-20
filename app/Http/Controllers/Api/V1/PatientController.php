<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  
use Illuminate\Support\Facades\Http;
use App\Models\Hospital;
use App\Models\Specialitie;
use App\Models\Patient;
use App\Models\User;
use App\Http\Requests\Api\PatientRequest;

class PatientController extends Controller
{
    /**
     * search hospital with hospital name 
    */
    public function hostpitalList($name){
        $list = Hospital::where('hospital_name','LIKE','%'.$name.'%')
                      ->get(['id','hospital_name']);
		if(count($list) > 0){
			return response()->json(['success' => '1','message' => 'List found successfully','details' => $list], 200);
		}
		return response()->json(['error' => 'No List found'], 401);
    }

    /**
     * seach specialities with speciality name
    */
    public function specialityList($name){
        $list = Specialitie::where('speciality_name','LIKE','%'.$name.'%')
                             ->get(['id','speciality_name']);
		if(count($list) > 0){
			return response()->json(['success' => '1','message' => 'List found successfully','details' => $list], 200);
		}
		return response()->json(['error' => 'No List found'], 401);
    }

    /**
     *  search reffer doctor with doctor name and email
    */
    public function referDoctorList($name){
        $list = User::where('name','LIKE','%'.$name.'%')
                     ->orWhere('email','LIKE','%'.$name.'%')
                      ->get(['id','name','email']);
        if(count($list) > 0){
             return response()->json(['success' => '1','message' => 'List found successfully','details' => $list], 200);
        }
        return response()->json(['error' => 'No List found'], 401);
    }

    /**
     * add patient api  
    */
    public function patientAdd(PatientRequest $request){
        $patientInfo = $request->all();
        $patientInfo['image'] = $this->fileUpload($request->file('image'));
        $patientInfo['doctor_id'] = Auth::user()->id; 
        $addPatient = Patient::create($patientInfo);
        if($addPatient){
            return response()->json(['success' => '1','message' => 'Patient added successfully'], 200);
        }
		return response()->json(['error' => 'Pleae try after some time'], 401);
    }

    /**
     * get patient list with doctor 
    */
    public function patientList(){
        $doctorId = Auth::user()->id;
        $list = Patient::join('hospitals','hospitals.id','=','patients.hospital_id')
                         ->join('specialities','specialities.id','=','patients.specialist_id')
                         ->join('users','users.id','=','patients.refer_doctor_id')
                         ->where('patients.doctor_id',$doctorId)
                         ->orderBy('patients.id','desc')
                         ->get(['patients.*','hospitals.hospital_name','specialities.speciality_name','users.name as doctor_name','users.email as doctor_email']);
        if(count($list) > 0){
            return response()->json(['success' => '1','message' => 'Patient List found successfully','details' => $list],200);
        }
		return response()->json(['error' => 'No list found'],401);
    }

    /**
     * delete patient with patient id 
    */
    public function patientDelete(Patient $id){
        $deletePatient = $id->delete();
        if($deletePatient){
            return response()->json(['success' => '1','message' => 'Patient deleted successfully'], 200);
        }
		return response()->json(['error' => 'Pleae try after some time'], 401);

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
