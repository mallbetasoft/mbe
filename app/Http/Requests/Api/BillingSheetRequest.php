<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BillingSheetRequest extends FormRequest
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
			'billing_sheet_file' =>  'required|image|mimes:jpeg,png,jpg|max:2048'
        ];
		
    }
	
	public function messages()
    {
        return [
            'billing_sheet_file.required' => 'Please upload billing sheet file!',
            'billing_sheet_file.mimes' => 'This format not accepted!, Please upload jpeg,png,jpg format file',
            'billing_sheet_file.image' => 'The type of the uploaded file should be an image.',
            'billing_sheet_file.max' => 'Failed to upload an file. The file maximum size is 2MB',
        ];
    }
	
	protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), self::UNPROCESSABLE_ENTITY));
    }
}
