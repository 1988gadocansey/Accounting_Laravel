<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashbookModel extends Model
{
    protected $table = 'tbl_cashbook';
     protected $primaryKey="ID";
     protected $fillable=array( "DATE", "REFERENCE_NO", "ACCOUNT", "CASHBOOK_TYPE", "ACCOUNT", "PAYMENT_TYPE", "MEMO","CHEQUE", "AMOUNT","TAG","RECONCILE","ACTOR","TRANSACTION_ID","TRANSACTION_TYPE","ACTOR","PERIOD","YEAR","RUNNING_BALANCE");

     public function account() {
        return $this->belongsTo('App\Models\AccountModel', "ACCOUNT","ACCOUNT_ID");
    }
    public function bankType() {
       return $this->belongsTo('App\Models\AccountModel', "CASHBOOK_TYPE","ACCOUNT_ID");
   }
     
    public function transactionType() {
        return $this->belongsTo('App\Models\ttypeModel', "TRANSACTION_TYPE","typeid");
    }
    public function tags() {
        return $this->belongsTo('App\Models\tagsModel', "TAG","ID");
    }
    public function payment_Type() {
        return $this->belongsTo('App\Models\PaymentTypeModel', "PAYMENT_TYPE","PAYMENT_METHOD_ID");
    }
    public function actor() {
        return $this->belongsTo('App\Models\LoginUser', "ACTOR","ID");
    }
}
