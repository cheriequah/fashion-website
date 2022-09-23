<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guard = 'admin';
    protected $fillable = [
        'name',
        'email',
        'password',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
