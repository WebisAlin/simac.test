<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facultate extends Model
{
   use HasFactory;
   protected $table = 'facultati';
   protected $primaryKey = 'id_facultate';


   public function utilizator()
   {
       return $this->belongsTo(Utilizator::class, 'id_utilizator', 'id_utilizator');
   }

   public function cadreDidactice()
   {
      return $this->hasMany(CadruDidactic::class, 'id_facultate');
   }
}
