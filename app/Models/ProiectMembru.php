<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProiectMembru extends Model
{
   use HasFactory;
   protected $table = 'proiecte_membri';
   protected $primaryKey = 'id_proiect_membru';

   public function proiect()
   {
      return $this->belongsTo(Proiect::class, 'id_proiect', 'id_proiect');
   }
   public function cd()
   {
      return $this->belongsTo(CadruDidactic::class, 'id_cd', 'id_cd');
   }
   
   public function atasamente()
   {
      return $this->hasMany(ProiectMembruAtasament::class, 'id_proiect_membru', 'id_proiect_membru');
   }
   

}
