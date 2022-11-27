<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    protected $table = 'code';
    public $timestamps = false;

    protected $fillable = ['code','account_id'];
}
