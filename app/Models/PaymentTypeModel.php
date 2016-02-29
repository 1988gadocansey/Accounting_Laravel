<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTypeModel extends Model
{
    protected $table = 'tbl_payment_method';
    protected $primaryKey="PAYMENT_METHOD_ID";
}
