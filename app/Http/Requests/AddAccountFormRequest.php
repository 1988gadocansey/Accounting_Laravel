<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddAccountFormRequest extends Request
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
        $rules = [
            'name' => 'required',
            
            'balance' => 'required|numeric',
            'type' => 'required',
            'code' => 'required|numeric',
            'people' => 'required',
            'affects' => 'required',
            'balance_type' => 'required',
             'naration' => 'required',
             
          ];
        return $rules;
    }
}
