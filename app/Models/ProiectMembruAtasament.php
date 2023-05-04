<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProiectMembruAtasament extends Model
{
   use HasFactory;
   protected $table = 'proiecte_membri_atasamente';
   protected $primaryKey = 'id_proiect_membru_atasament';

   public function membru_proiect()
   {
      return $this->belongsTo(ProiectMembru::class, 'id_proiect_membru', 'id_proiect_membru');
   }

}
