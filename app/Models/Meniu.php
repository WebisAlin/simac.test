<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meniu extends Model
{
   use HasFactory;
   protected $table = 'meniuri';
   protected $primaryKey = 'id_meniu';

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }
    
    public function elemente()
    {
        return $this->hasMany(MeniuElement::class, 'id_meniu', 'id_meniu');
    }
    public function utilizator()
   {
       return $this->belongsTo(Utilizator::class, 'id_utilizator', 'id_utilizator');
   }

}
