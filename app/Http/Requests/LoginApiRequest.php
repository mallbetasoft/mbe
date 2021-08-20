<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginApiRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required'
          ];   
    }
	
	public function messages()
    {
        return [
            'email.required' => 'Please enter your email address!',
            'email.email' => 'Please enter valid email address!',
            'password.required' => 'Please enter your password!'
        ];
    }
	
	protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), self::UNPROCESSABLE_ENTITY));
    }
}
