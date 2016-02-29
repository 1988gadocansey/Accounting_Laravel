<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AssetRequest extends Request
{
    public function  messages() {

      return array(
            'name.required'=>"The Asset Name is required and cannot be empty!",
            'cost.numeric'=>"The cost of the asset should be an amount!",
            'cost.required'=>"The  cost of the assets is required!",
            'number.required'=>"The  bank account number is required",
            'balance_type.required'=>"The  balance type is required",
           'affects.required'=>"Please choose at least one report type this cashbook affects",
          );

    }
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
            
            'account' => 'required',
            'location' => 'required',
            'depreciation_method' => 'required',
            'category' => 'required',
            'cost' => 'required|numeric',
            'date' => 'required',
           
             
          ];
        return $rules;
    }
}
