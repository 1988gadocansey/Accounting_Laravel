<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class bankTransferRequest extends Request
{
     public function  messages() {

      return array(
             
            'date.required'=>"The  transaction date is required",
            'type.required'=>"The  transaction type is required",
          'memo.required'=>"The  transaction date is required",
          'cheque.numeric'=>"The Cheque number must be numeric",
          'into.required'=>"The  receiving bank/cashbook  is required",
           'from.required'=>"Please provide source bank account name",
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
              
             'date'=>'required',
             'amount' => 'required|numeric',
             'cheque' => 'numeric',
             'type'=>'required',
             'into'=>'required',
             'from'=>'required',
             'memo'=>'required',
           
        ];
    }
}
