<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile_photo extends Model
{
    use HasFactory;

    protected $table = 'profile_protos';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'path',
    ];
}
