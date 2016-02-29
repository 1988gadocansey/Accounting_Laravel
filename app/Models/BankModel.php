<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankModel extends Model
{
    //
    //
      protected $table = 'tbl_bank_account';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
      protected $primaryKey="BANK_ACCOUNT_ID";
     protected $fillable=array("BANK_ACCOUNT_NAME", "BANK_NAME","GL_ACCOUNT","BANK_CURRENCY","BANK_ACCOUNT_NUMBER","BANK_ACCOUNT_TYPE", "PERIOD","YEAR","CREATED_BY","UPDATED_BY");

      /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
      protected $dates = ['deleted_at'];
      
       public function account() {
        return $this->belongsTo('App\Models\AccountModel', "GL_ACCOUNT","ACCOUNT_ID");
    }
     public function bankName() {
        return $this->hasMany(App\Models\CashbookModel, "CASHBOOK_TYPE","BANK_ACCOUNT_ID");
    }
}
