<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportProcess extends Model
{
    protected $primaryKey = 'rp_id';
    protected $keyType = 'int';
    protected $fillable = [
        'rp_id',
        'rp_pid',
        'rp_start_datetime',
        'rp_exec_time',
        'ps_id',
        'rp_file_save_path',
    ];

    public function status()
    {
        return $this->belongsTo(ProcessStatus::class, 'ps_id', 'ps_id');
    }
}
