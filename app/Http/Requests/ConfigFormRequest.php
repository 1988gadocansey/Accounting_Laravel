<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ConfigFormRequest extends Request
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
            
            'email' => 'required|email',
            'phone' => 'required',
            'basis' => 'required',
            'tax' => 'required',
            'address' => 'required',
            'city' => 'required',
            'year_start' =>  'required',
            'year_end' => 'required',
          ];
        return $rules;
    }
    public function messages() {
         return array(
            'name.required'=>"The company name is required and cannot be empty!",
            'email.required'=>"The email is required and cannot be empty!",
               'year_start.required'=>"The starting financial year is required and cannot be empty!",
              'basis.required'=>"The accounting basis is required and cannot be empty!",
             'address.required'=>"The address field is required and cannot be empty!",
             'year_end.required'=>"The ending financial year required and cannot be empty!",
               'tax.required'=>"The Tax ID is required and cannot be empty!",
              'phone.required'=>"The phone number and telephone are required and cannot be empty!",
          );
    }
}
