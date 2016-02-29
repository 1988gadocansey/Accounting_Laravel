<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountClassesModel extends Model
{
    //
    protected $table="tbl_account_classes";
    protected $primaryKey="id";
    
    public function accountClass() {
        
        return $this->hasMany('App\Models\ParentAccountModel', "TYPE","id");
    }
}
