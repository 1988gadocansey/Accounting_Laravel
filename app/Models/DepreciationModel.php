<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepreciationModel extends Model
{
    //
    protected $table="tbl_depreciation_method";
    protected $guarded="ID";
    
    public function parent_depreciate() {
        return $this->hasMany(App\Models\AssetModel, "FIXED_ASSET_DEPRECIATION_METHOD","ID");
    }
}
