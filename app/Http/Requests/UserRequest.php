<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
            'txtName'       => 'required',
            'sltDepartment' => 'required',
            'rdbLevel'      => 'required',
            'sltRole'       => 'required',
            'txtBirth'      => 'required',
            'txtPass'       => 'required|min:6',
            'txtRePass'     => 'required|same:txtPass',
            'txtEmail'      => 'required|unique:staff,email|email'

        ];
    }    
    public function messages()
    {
        return[
            'txtName.required'          => 'Please enter a name',
            'sltDepartment.required'    => 'Please select department',
            'rdbLevel.required'         =>'Please select level',
            'sltRole.required'          => 'Please select user\'s role',
            'txtPass.required'          => 'User\'s name couldn\'t be blank',
            'txtPass.min'               => 'Password must be 6 characters at least.',
            'txtBirth.required'         => 'User\'s birthday couldn\'t be blank',
            'txtRePass.required'        => 'Please repeat the password',
            'txtRePass.same'            => 'Password must match.',
            'txtEmail.required'         => 'User\'s Email couldn\'t be blank',
            'txtEmail.unique'           => 'The Email has already been taken',
            
            
        ];
    }
}
