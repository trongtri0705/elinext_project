<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StaffRequest extends Request
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
    public function rules()
    {
        return [
            //
            'password' => 'required',            
            'email' => 'required|email'

        ];
    }    
    public function messages()
    {
        return[           
            'password.required' => 'nhap pass vo ba',            
            'email.required' => 'sao chua nhap email nua',            
        ];
    }
}
