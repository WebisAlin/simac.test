<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrantCerere extends Model
{
   use HasFactory;
   protected $table = 'granturi_cerere';
   protected $primaryKey = 'id_grant_cerere';

   public function anexa6(){
      return $this->belongsTo(Anexa6::class, 'id_grant_cerere' ,'id_grant_cerere');
   }

   public function anexa5(){
      return $this->belongsTo(Anexa5::class, 'id_grant_cerere' ,'id_grant_cerere');
   }

   public function anexa4(){
      return $this->belongsTo(Anexa4::class, 'id_grant_cerere' ,'id_grant_cerere');
   }

   public function anexa3(){
      return $this->belongsTo(Anexa3::class, 'id_grant_cerere' ,'id_grant_cerere');
   }

   public function anexa2(){
      return $this->belongsTo(Anexa2::class, 'id_grant_cerere' ,'id_grant_cerere');
   }

   public function anexa1(){
      return $this->belongsTo(Anexa1::class, 'id_grant_cerere' ,'id_grant_cerere');
   }

}
