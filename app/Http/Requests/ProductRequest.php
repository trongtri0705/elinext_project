<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends Request
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
            'sltParent' => 'required',
            'txtName' => 'required|unique:products,name',
            'fImages' => 'required|image'
        ];
    }
    public function messages(){
        return[
            'sltParent.required' => 'Haven\'t chosen a Cate, yet!',
            'txtName.required' => 'Haven\'t set a name, yet!',
            'txtName.unique' => 'Existed name',
            'fImages.required' => 'Haven\'t put an image, yet!',
            'fImage.image' => 'File\'s inputted isn\'t allowed'
        ];
    }
}
