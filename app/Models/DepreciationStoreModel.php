<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepreciationStoreModel extends Model
{
    //
    protected $table="tbl_depreciation_calculation";
    protected $guarded="ID";
    
    public function asset() {
        return $this->belongsTo(App\Models\AssetModel, "ASSET","ID");
    }
}
