<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    /**
     * Mass-assignable fields for the custom auth table.
     */
    protected $fillable = [
        'username',
        'password_hash',
        'salt',
    ];

    /**
     * Hide sensitive fields if this model is serialized.
     */
    protected $hidden = [
        'password_hash',
        'salt',
    ];
}
