<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilizator extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'utilizatori';
    
    protected $primaryKey = 'id_utilizator';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    public function notificari()
    {
        return $this->hasMany(UtilizatorNotificare::class, 'id_utilizator');
    }
    public function notificariNecitite()
    {
        return $this->hasMany(UtilizatorNotificare::class, 'id_utilizator')->where('citita',0);
    }

    protected $fillable = [
        'nume_utilizator',
        'prenume_utilizator',
        'email_utilizator',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}