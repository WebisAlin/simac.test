<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilizatorNotificare extends Model
{
   use HasFactory;
   protected $table = 'utilizatori_notificari';
   protected $primaryKey = 'id_utilizator_notificare';

   public function notificare()
   {
        return $this->belongsTo(Notificare::class, 'id_notificare', 'id_notificare');
   }

   public function utilizator()
   {
       return $this->belongsTo(Utilizator::class, 'id_utilizator', 'id_utilizator');
   }
  
}
