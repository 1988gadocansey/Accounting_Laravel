<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockModel extends Model
{
    protected $table = 'tbl_stock';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $primaryKey="ITEM_ID";
     protected $guarded=array("ITEM_ID");
     public function account() {
        return $this->belongsTo('App\Models\AccountModel', "ITEM_ACCOUNT","ACCOUNT_ID");
    }

}
