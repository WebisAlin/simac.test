<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proiect extends Model
{
   use HasFactory;
   protected $table = 'proiecte';
   protected $primaryKey = 'id_proiect';

   public function utilizator()
   {
      return $this->belongsTo(Utilizator::class, 'id_utilizator', 'id_utilizator');
   }
   public function director()
   {
      return $this->belongsTo(CadruDidactic::class, 'id_cd', 'id_cd');
   }
   public function tip_proiect()
   {
      return $this->belongsTo(ProiectTip::class, 'id_tip_proiect', 'id_tip_proiect');
   }
   public function pontaje()
   {
      return $this->hasMany(ProiectPontaj::class, 'id_proiect', 'id_proiect');
   }
   public function membri()
   {
      return $this->hasMany(ProiectMembru::class, 'id_proiect', 'id_proiect');
   }
}
