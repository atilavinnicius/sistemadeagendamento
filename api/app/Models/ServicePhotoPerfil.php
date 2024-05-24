<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePhotoPerfil extends Model
{
    use HasFactory;

    protected $table = 'service_photo_perfil';

    protected $fillable = ['service_id', 'path'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
