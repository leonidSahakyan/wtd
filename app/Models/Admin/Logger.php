<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Logger extends Model
{
    protected $table = 'log';

    protected $fillable = [
        'owner_id',
        'type',
        'data',
        'owner_type',
    ];

    public function setUpdatedAtAttribute($value)
    {
        
    }
}
