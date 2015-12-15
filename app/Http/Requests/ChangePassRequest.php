<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ChangePassRequest extends Request
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
            'txtOldPass'    => 'required',
            'txtPass'       => 'required',            
            "txtRePass"     =>"same:txtPass|min:5|different:txtOldPass",

        ];
    }    
    public function messages()
    {
        return[
            'txtOldPass.required'   => 'What is your current password',
            'txtRePass.min'         => 'Please make a longer one',
            'txtRePass.different'   => 'You entered the same one',
            'txtPass.required'      => 'You don\'t have a password?',            
            'txtRePass.same'        => 'Don\'t be a hacker',
           
            
        ];
    }
}
