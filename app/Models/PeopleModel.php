<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeopleModel extends Model
{
    //
    //
    //
      protected $table = 'tbl_business_people';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      protected $primaryKey="BP_ID";
     protected $fillable=array("BP_NAME", "BP_EMAIL","BP_PHONE", "BP_ADDRESS","BP_TYPE","BP_NOTE","BP_WEBSITE","BP_SINCE","BP_PAYMENT_TERM","BP_OPEN_BALANCE");

}
