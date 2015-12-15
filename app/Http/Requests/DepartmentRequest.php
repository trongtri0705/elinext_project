<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DepartmentRequest extends Request
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
            'txtName' => 'required|unique:department,name'
        ];
    }
    public function messages(){
        return[
            'txtName.required' => 'Please enter Department\'s name',
            'txtName.unique' => 'This name has been already existed '
        ];
    }
}
