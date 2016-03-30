<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceModel extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_attendance';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    public function employee() {
        return $this->belongsTo('App\Models\EmployeeModel', "employee_id","id");
    }

    public $timestamps = false;

}
