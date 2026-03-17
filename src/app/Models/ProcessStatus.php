<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessStatus extends Model
{
    protected $primaryKey = 'ps_id';
    protected $keyType = 'int';
    protected $fillable = [
        'ps_id',
        'ps_name',
    ];

    const STATUS_STARTING = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_ERROR = 3;
}
