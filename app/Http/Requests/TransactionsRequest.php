<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TransactionsRequest extends Request
{
     public function  messages() {

      return array(
            'amount.required'=>"The cost of transaction is required!",
            'credit.required'=>"The   ledger account  to be credited  is required!",
            'amount.numeric'=>"The amount must be a number!",
            'debit.required'=>"select account to be debited",
            'type.required'=>"The type of transaction is required",
            'memo.required'=>"The memo is required",
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
             'memo'=>'required',
             'amount'=>'required|numeric',
             'debit'=>'required',
             'credit'=>'required',
             'date'=>'required',
             'type'=>'required',
           
        ];
    }
}
