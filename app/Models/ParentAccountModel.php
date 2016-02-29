<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentAccountModel extends Model
{
    //
    protected $table="tbl_parent_account";
   protected $primaryKey="PARENT_ACCOUNT_ID";
    protected $fillable=array("PARENT_NAME","TYPE");

    public function child_accounts() {
        return $this->hasMany('App\Models\AccountModel', "PARENT_ACCOUNT","PARENT_ACCOUNT_ID");
    }
    // belongs to sections tbl_account_classes
    public function class_account() {
        return $this->belongsTo('App\Models\AccountClassesModel', "TYPE","id");
    }
}
