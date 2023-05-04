<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
   use HasFactory;
   protected $table = 'roluri';
   protected $primaryKey = 'id_rol';

   public function utilizatori()
   {
      return $this->hasMany(Utilizator::class, 'id_rol', 'id_rol');
   }
   public function meniu()
   {
      return $this->belongsTo(Meniu::class, 'id_rol', 'id_rol');
   }

   public function utilizator()
   {
       return $this->belongsTo(Utilizator::class, 'id_utilizator', 'id_utilizator');
   }

}
