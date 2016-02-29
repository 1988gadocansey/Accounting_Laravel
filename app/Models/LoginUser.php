<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginUser extends Model
{
    //
  protected $table='tbl_users';
  protected $primaryKey="ID";
  protected $fillable=array('USERNAME','PASSWORD','ROLE_ID','STATUS','EMAIL');
}
