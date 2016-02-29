<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class systemLogModel extends Model
{
    protected $table = 'tbl_system_log';
     protected $primaryKey="ID";
     protected $fillable=array(   "USERNAME", "EVENT_TYPE","PAGES_VISITED", "ACTIVITIES", "HOSTNAME", "IP", "BROWSER_VERSION" );

     
     
    public function user() {
        return $this->belongsTo('App\Models\LoginUser', "USERNAME","ID");
    }
    public function eventTypes() {
         return $this->belongsTo('App\Models\ttypeModel', "EVENT_TYPE","typeid");
    }
}
