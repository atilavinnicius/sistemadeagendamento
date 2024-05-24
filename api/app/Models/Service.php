<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = ['title', 'description', 'price','user_id'];

    public function photos()
    {
        return $this->hasMany(ServicePhoto::class);
    }

    public function perfilPhoto()
    {
        return $this->hasOne(ServicePhotoPerfil::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
