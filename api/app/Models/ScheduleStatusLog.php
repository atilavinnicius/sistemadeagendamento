<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleStatusLog extends Model
{
    use HasFactory;

    protected $table = 'schedules_status_logs';

    protected $fillable = [
        'schedule_id',
        'description',
        'user_id',
        'notify_client',
        'notify_admin',
    ];

    public function serviceSchendule()
    {
        return $this->belongsTo(ServiceSchedule::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
