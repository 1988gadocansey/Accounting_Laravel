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
     protected $primaryKey="id";
     protected $guarded = ['ID'];
    
    public function departments(){
        return $this->belongsTo('App\Models\DepartmentModel', "department","ID");
    }
    public function leave() {
        return $this->belongsTo('App\Models\LeaveApplicationModel', "id","Employee");
    }
    
    
    

}
