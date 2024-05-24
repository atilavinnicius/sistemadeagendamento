<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilePhoto extends Model
{
    use HasFactory;

    protected $table = 'profile_protos';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'path',
    ];
}
