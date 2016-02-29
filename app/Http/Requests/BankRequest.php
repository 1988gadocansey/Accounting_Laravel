<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BankRequest extends Request
{
     public function  messages() {

      return array(
            'name.required'=>"The Cashbook Name is required and cannot be empty!",
            'balance.numeric'=>"The  cashbook balance must be an amont!",
            'number.numeric'=>"The  bank account number must be a number!",
            'number.required'=>"The  bank account number is required",
            'type.required'=>"The  account type is required",
          'account.required'=>"The  GL account  is required",
           'accountname.required'=>"Please provide bank account name",
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
         return [
            //
             'name'=>'required',
             'account'=>'required',
             'number' => 'required|numeric',
             'balance' => 'numeric',
             'type'=>'required',
             'accountname'=>'required',
           
        ];
    }
}
