<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveModel extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_leave_category';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'category', 'note'];

    public $timestamps = false;

}