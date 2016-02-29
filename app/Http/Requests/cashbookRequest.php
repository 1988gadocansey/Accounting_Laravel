<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class cashbookRequest extends Request
{
    public function  messages() {

      return array(
            'memo.required'=>"The Memo is required and cannot be empty!",
            'amount.numeric'=>"The withdrawal amount must be a numeric figure!",
            'cheque.numeric'=>"The  cheque number must be a number!",
            'amount.required'=>"The  withdrawal amount is required",
            'type.required'=>"The transaction type  is required",
            'account.required'=>"The  GL account  is required",
            'bank.required'=>"Please select bank account name",
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
             'account'=>'required',
             'cheque' => 'numeric',
             'amount' => 'numeric|numeric',
             'type'=>'required',
             'bank'=>'required',
             'memo'=>'required',
           
        ];
    }
}
