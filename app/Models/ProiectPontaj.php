<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProiectPontaj extends Model
{
   use HasFactory;
   protected $table = 'proiecte_pontaje';
   protected $primaryKey = 'id_pontaj';  

   public function cd()
   {
      return $this->belongsTo(CadruDidactic::class, 'id_cd', 'id_cd');
   }
   public function proiect()
   {
      return $this->belongsTo(Proiect::class, 'id_proiect', 'id_proiect');
   }
   
   
}
