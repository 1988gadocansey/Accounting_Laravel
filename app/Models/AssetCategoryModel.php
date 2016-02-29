<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetCategoryModel extends Model
{
    //
    protected $table="tbl_fixed_asset_categories";
    protected $guarded="ID";
    
    public function child_assets() {
        return $this->hasMany(App\Models\AssetModel, "FIXED_ASSET_CATEGORY","ID");
    }
}
