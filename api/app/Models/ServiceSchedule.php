<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSchedule extends Model
{
    use HasFactory;

    protected $table = 'service_schedules';

    protected $fillable = [
        'date_time',
        'client_id',
        'status',
        'service_id',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
