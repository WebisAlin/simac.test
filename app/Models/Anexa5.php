<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anexa5 extends Model
{
   use HasFactory;
   protected $table = 'granturi_anexa5';
   protected $primaryKey = 'id_anexa5';

   public function cerereGrant()
   {
       return $this->belongsTo(GrantCerere::class, 'id_grant_cerere', 'id_grant_cerere');
   }

}
