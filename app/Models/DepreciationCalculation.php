<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepreciationCalculation extends Model
{
    //
     protected $table="tbl_depreciation_calculation";
    protected $guarded="ID";
    
     protected $fillable=array("ASSET", "METHOD","CALCULATION","PERIOD");

}
