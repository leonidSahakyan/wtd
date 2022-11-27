<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Settings extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';

    public $timestamps  = false;
    protected $fillable = [
        'id',
        'key',
        'value'
    ];

}

