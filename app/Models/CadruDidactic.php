<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class CadruDidactic extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'cadre_didactice';
    
    protected $primaryKey = 'id_cd';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function facultate()
    {
        return $this->belongsTo(Facultate::class, 'id_facultate');
    }

    public function departament()
    {
        return $this->belongsTo(Departament::class, 'id_departament');
    }

    public function proiecte_membri()
    {
        return $this->hasMany(ProiectMembru::class, 'id_cd');
    }

    public function proiecte()
    {
        return $this->hasMany(Proiect::class, 'id_cd');
    }

    public function pontaje()
    {
        return $this->hasMany(ProiectPontaj::class, 'id_cd');
    }

    public function cereri_granturi()
    {
        return $this->hasMany(GrantCerere::class, 'id_cd','id_cd');
    }
    public function granturi()
    {
        return $this->hasMany(Grant::class, 'id_cd','id_cd');
    }

    public function granturi_autori()
    {
        return $this->hasMany(GrantAutorUtcn::class, 'id_cd', 'id_cd');
    }

    protected $fillable = [
        'nume_cd',
        'prenume_cd',
        'email_cd',
        'telefon_cd',
        'semnatura_cd',
        'ut',
        'universitate_cd',
        'facultate_cd',
        'departament_cd',
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

    public function utilizator()
   {
       return $this->belongsTo(Utilizator::class, 'id_utilizator', 'id_utilizator');
   }
}
