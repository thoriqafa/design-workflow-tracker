<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkProgressTextReview extends Model
{
    protected $table = 'tx_work_progress_text_reviews';

    protected $fillable = [
        'tx_work_progress_id',
        'name',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
