<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificare extends Model
{
   use HasFactory;
   protected $table = 'notificari';
   protected $primaryKey = 'id_notificare';

   public function utilizatori_notificare()
   {
      return $this->belongsTo(UtilizatorNotificare::class, 'id_notificare', 'id_notificare');
   }
  
}
