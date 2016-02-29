<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StockRequest extends Request
{
     public function  messages() {

      return array(
            'item.required'=>"The Item or stock Name is required and cannot be empty!",
            'account.required'=>"The   ledger account this stock should be kept in is required!",
            'price.numeric'=>"The unit price of stock must be a number!",
            'quantity'=>"The  quantity of the stock is required",
            'date.required'=>"The date the stock is acquired is required",
            
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
             'item'=>'required',
             'quantity'=>'required',
              
             'account' => 'required',
             'price'=>'required|numeric',
             'date'=>'required',
              
           
        ];
    }
}
