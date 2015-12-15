<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LevelRequest extends Request
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
            'sltRole' => 'required',
            'txtName' => 'required|unique:levels,name'
        ];
    }
    public function messages(){
        return[
            'sltRole.required' => 'Please select a role',
            'txtName.required' => 'Please enter Level\'s name',
            'txtName.unique' => 'This name has been already existed'
        ];
    }
}
