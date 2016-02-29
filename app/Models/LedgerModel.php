<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LedgerModel extends Model
{
    //
     protected $table = 'tbl_general_ledger_transactions';
    
    protected $guarded = ['TRANS_DATE', 'ACCOUNT', 'PERIOD','ID','DEBIT','CREDIT','ACTOR','YEAR'];
       
}
