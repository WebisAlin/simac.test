<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Universitate extends Model
{
   use HasFactory;
   protected $table = 'universitati';
   protected $primaryKey = 'id_universitate';

   public function utilizator()
   {
       return $this->belongsTo(Utilizator::class, 'id_utilizator', 'id_utilizator');
   }
}
