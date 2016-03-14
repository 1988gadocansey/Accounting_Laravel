<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_employee';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['employee_id', 'employment_id', 'first_name', 'last_name', 'date_of_birth', 'gender', 'maratial_status', 'father_name', 'nationality', 'passport_number', 'photo', 'photo_a_path', 'present_address', 'city', 'country_id', 'mobile', 'phone', 'email', 'designations_id', 'joining_date', 'status'];

    public $timestamps = false;

}
