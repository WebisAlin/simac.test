<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
   use HasFactory;
   protected $table = 'departamente';
   protected $primaryKey = 'id_departament';


   public function utilizator()
   {
       return $this->belongsTo(Utilizator::class, 'id_utilizator', 'id_utilizator');
   }

   public function cadreDidactice()
   {
      return $this->hasMany(CadruDidactic::class, 'id_departament');
   }

}
