<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralLedgerModel extends Model
{
    //
     protected $table = 'tbl_general_ledger_transactions';
     protected $primaryKey="ID";
     protected $fillable=array( "TRANS_DATE", "PERIOD", "ACCOUNT", "NARRATIVE", "DEBIT", "CREDIT", "TAG","TRANSACTION_ID", "TRANSACTION_TYPE","YEAR","RECONCILE","ACTOR","DELETED");

     public function account() {
        return $this->belongsTo('App\Models\AccountModel', "ACCOUNT","ACCOUNT_ID");
    }
     
    public function transactionType() {
        return $this->belongsTo('App\Models\ttypeModel', "TRANSACTION_TYPE","typeid");
    }
    public function tags() {
        return $this->belongsTo('App\Models\tagsModel', "TAG","ID");
    }
    public function actor() {
        return $this->belongsTo('App\Models\LoginUser', "ACTOR","ID");
    }
}
