<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePhoto extends Model
{
    use HasFactory;
    protected $table = 'services_photos';

    protected $fillable = ['service_id', 'path'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
