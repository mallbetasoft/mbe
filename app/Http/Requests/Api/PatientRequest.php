<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    const UNPROCESSABLE_ENTITY = 422;
    
    public function rules()
    {
        return [
			'image' =>  'required|image|mimes:jpeg,png,jpg|max:2048',
            'first_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required|date_format:Y-m-d',
            'hospital_id' => 'required',
            'specialist_id' => 'required',
            'admission_date' => 'required|date_format:Y-m-d',
            'admission_status' => 'required',
            'refer_doctor_id' => 'required',
            'date_of_schedule' => 'required|date_format:Y-m-d',
            'referral_date' => 'required|date_format:Y-m-d',
        ];
		
    }
	
	public function messages()
    {
        return [
            'image.required' => 'Please upload image!',
            'image.mimes' => 'This format not accepted!, Please upload jpeg,png,jpg format image',
            'image.image' => 'The type of the uploaded image should be an image.',
            'image.max' => 'Failed to upload an image. The file maximum size is 2MB',
            'first_name.required' => 'Please enter first name', 
            'last_name.required' => 'Please enter first name', 
            'dob.required' => 'Please enter DOB',
            'dob.date_format' => 'Invalid date format!, Y-m-d',
            'hospital_id.required' => 'Please select hostpital', 
            'specialist_id.required' => 'Please select speciality', 
            'admission_date.required' => 'Please enter adminssion date',
            'admission_date.date_format' => 'Invalid date format!, Y-m-d',
            'admission_status.required' => 'Please select adminssion status', 
            'refer_doctor_id.required' => 'Please select doctor', 
            'date_of_schedule.required' => 'Please enter schedule date',
            'date_of_schedule.date_format' => 'Invalid date format!, Y-m-d',
            'referral_date.required' => 'Please enter referral date',
            'referral_date.date_format' => 'Invalid date format!, Y-m-d',
        ];
    }
	
	protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), self::UNPROCESSABLE_ENTITY));
    }
}
