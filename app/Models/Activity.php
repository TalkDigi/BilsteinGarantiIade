<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity as SpatieActivity;
use Carbon\Carbon;

class Activity extends SpatieActivity
{

    protected $table = 'activity_log';

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->locale('tr')->isoFormat('D MMM');
    }
}