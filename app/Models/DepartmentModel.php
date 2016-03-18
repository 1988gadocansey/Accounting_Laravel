<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentModel extends Model
{
    //
    protected $table="tbl_department";
    protected $guarded="ID";
    public $timestamps = false;
    public function child_assets() {
        return $this->hasMany(App\Models\AssetModel, "FIXED_ASSET_LOCATION","ID");
    }
}
