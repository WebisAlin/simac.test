<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProiectTip extends Model
{
   use HasFactory;
   protected $table = 'proiecte_tipuri';
   protected $primaryKey = 'id_tip_proiect';  

   public function utilizator()
   {
      return $this->belongsTo(Utilizator::class, 'id_utilizator', 'id_utilizator');
   }
   public function copii()
   {
      return $this->hasMany(ProiectTip::class, 'parinte', 'id_tip_proiect');
   }
   public function parinteMostenit()
   {
      return $this->belongsTo(ProiectTip::class, 'parinte', 'id_tip_proiect');
   }
}
