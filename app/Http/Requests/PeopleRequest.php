<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PeopleRequest extends Request
{
    public function  messages() {

      return array(
            'name.required'=>"The Person Name is required and cannot be empty!",
            'balance.numeric'=>"The  Person ledger balance must be an amount!",
            'phone.numeric'=>"The Phone or Telephone number must be a number!",
            'website.url'=>"The  Website address is not valid eg http://www.me.com",
            'balance_type.required'=>"The  balance type is required",
            'person_type.required'=>"Please choose  person type",
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
             'term'=>'required',
             'email' => 'required|email',
             'balance' => 'numeric',
             'phone'=>'required|numeric',
             'website'=>'url',
             'person_type'=>'required',
           
        ];
    }
}
