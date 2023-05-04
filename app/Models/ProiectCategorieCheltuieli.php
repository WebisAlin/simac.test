<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProiectCategorieCheltuieli extends Model
{
   use HasFactory;
   protected $table = 'proiecte_categorii_bugete';
   protected $primaryKey = 'id_proiect_categorie_cheltuieli';  

   public function utilizator()
   {
      return $this->belongsTo(Utilizator::class, 'id_utilizator', 'id_utilizator');
   }
   public function copii()
   {
      return $this->hasMany(ProiectCategorieCheltuieli::class, 'parinte', 'id_proiect_categorie_cheltuieli');
   }
   public function parinteMostenit()
   {
      return $this->belongsTo(ProiectCategorieCheltuieli::class, 'parinte', 'id_proiect_categorie_cheltuieli');
   }
}
