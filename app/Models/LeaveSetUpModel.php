<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveSetUpModel extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_leave_setup';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    
protected $guarded=array("id");
protected $fillable=array("Type","duration",'Working_Days','Paid','note');

    public $timestamps = false;

}
