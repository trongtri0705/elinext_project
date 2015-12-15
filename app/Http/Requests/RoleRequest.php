<?php

namespace App\Http\Requests;

use App\Custom\Active\ActiveRequest;

class RoleRequest extends ActiveRequest
{
    public $model = 'Role';
    
    public function rules()
    {
        return [
            
            'name' => 'required|unique:roles'

        ];
    }
}
