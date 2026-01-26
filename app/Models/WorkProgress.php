<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkProgress extends Model
{
    use SoftDeletes;

    protected $table = 'tx_work_progress';

    protected $fillable = [
        'supplier',
        'item',
        'no_approval',
        'email_received_at',
        'start_time',
        'end_time',
        'status_work',
        'duration',
        'computer_ip',
        'computer_name',
        'remarks',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['deleted_at'];

    public function colorReview()
    {
        return $this->hasMany(
            WorkProgressColorReview::class,
            'tx_work_progress_id'
        );
    }

    public function textReview()
    {
        return $this->hasMany(
            WorkProgressTextReview::class,
            'tx_work_progress_id'
        );
    }

    public function createdBy()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    public function approvedBy()
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }
}
