<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProiectEntitate extends Model
{
   use HasFactory;
   protected $table = 'proiecte_entitati';
   protected $primaryKey = 'id_proiect_entitate';

   public function proiect()
   {
      return $this->belongsTo(Proiect::class, 'id_proiect', 'id_proiect');
   }
   public function universitate()
   {
      return $this->belongsTo(Universitate::class, 'id_universitate', 'id_universitate');
   }
   

}
