<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
        'estado',
        'foto_perfil',
        'area',
    ];

    // Define los atributos que se auditarán
    protected static $logAttributes = ['name', 'email', 'password', 'estado', 'foto_perfil', 'area'];
    protected static $logName = 'users';
    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return "El usuario ha sido {$eventName}";
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
