<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProiectNotificare extends Model
{
   use HasFactory;
   protected $table = 'proiecte_notificari';
   protected $primaryKey = 'id_proiect_notificare';

   public function proiect()
   {
      return $this->belongsTo(Proiect::class, 'id_proiect', 'id_proiect');
   }
   

}
