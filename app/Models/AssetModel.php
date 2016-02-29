<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetModel extends Model
{
    protected $table = 'tbl_fixed_assets_manager';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $primaryKey="ID";
     protected $fillable=array("FIXED_ASSET_CODE","FIXED_ASSET_NAME", "FIXED_ASSET_DEPRECIATION_METHOD","FIXED_ASSET_CATEGORY", "FIXED_ASSET_LOCATION", "FIXED_ASSET_DESCRIPTION","FIXED_ASSET_BARCODE", "FIXED_ASSET_COST", "FIXED_ASSET_DEPRECIATION_RATE", "FIXED_ASSET_SERIAL_NUMBER", "FIXED_ASSETS_DATE_PURCHASE","FIXED_ASSET_ACCOUNT","SALVAGE_VALUE","USEFUL_LIFE","PERIOD");

     public function account() {
        return $this->belongsTo('App\Models\AccountModel', "FIXED_ASSET_ACCOUNT","ACCOUNT_ID");
    }
    public function child_depreciate() {
        return $this->belongsTo('App\Models\DepreciationModel', "FIXED_ASSET_DEPRECIATION_METHOD","ID");
    }
    public function departments() {
        return $this->belongsTo('App\Models\DepartmentModel', "FIXED_ASSET_LOCATION","ID");
    }
    public function category() {
        return $this->belongsTo('App\Models\AssetCategoryModel', "FIXED_ASSET_CATEGORY","ID");
    }
}
