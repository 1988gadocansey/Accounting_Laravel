<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetupModel extends Model
{
    //
     protected $table = 'tbl_company_info';
    protected $fillable=array("COMPANY_NAME", "COMPANY_LEGAL_NAME","COMPANY_TAX_ID", "COMPANY_ADDRESS", "COMPANY_CITY", "COMPANY_REGION", "COMPANY_TELEPHONE", "COMPANY_PHONE", "COMPANY_EMAIL", "COMPANY_WEBSITE", "START_YEAR", "END_YEAR","ACCOUNTING_BASIS");
}
