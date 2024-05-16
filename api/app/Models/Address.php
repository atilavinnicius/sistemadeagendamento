<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'zip_code',
        'address',
        'number',
        'neighborhood',
        'city',
        'state',
        'complement',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
