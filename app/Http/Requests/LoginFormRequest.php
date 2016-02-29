<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LoginFormRequest extends Request
{


  public function  messages() {

      return array(
            'password.required'=>"The password is required and cannot be empty!",
            'username.required'=>"The username is required and cannot be empty!"
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
           'username'=>'required',
           'password'=>'required'
        ];
        
    }
}
