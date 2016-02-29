<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AccountModel extends Model
{
    //
      protected $table = 'tbl_accounts';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      protected $primaryKey="ACCOUNT_ID";
     protected $fillable=array("ACCOUNT_NAME", "PARENT_ACCOUNT","ACCOUNT_DESCRIPTION", "AFFECTS", "ACCOUNT_BALANCE", "ACCOUNT_CODE", "BALANCE_TYPE", "BUSINESS_PERSON", "PERIOD");

      /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
      protected $dates = ['deleted_at'];
      
       public function parent_account() {
        return $this->belongsTo('App\Models\ParentAccountModel', "PARENT_ACCOUNT","PARENT_ACCOUNT_ID");
    }
}
      

