<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveApplicationModel extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_leave';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [  'Type', 'Employee', 'Start', 'Due', 'Reasons', 'Leave_Left', 'Status' ];

    public $timestamps = false;
    public function employee() {
        return $this->belongsTo('App\Models\EmployeeModel', "Employee","id");
    }
    public function supervisor() {
        return $this->belongsTo('App\Models\EmployeeModel', "Employee","id");
    }
    public function approval() {
        return $this->belongsTo('App\Models\EmployeeModel', "Approved_By","id");
    }
    public function type() {
        return $this->belongsTo('App\Models\LeaveModel', "Type","id");
    }
}
