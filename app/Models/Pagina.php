<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
   use HasFactory;
   protected $table = 'pagini';
   protected $primaryKey = 'id_pagina';

   public function utilizator()
   {
       return $this->belongsTo(Utilizator::class, 'id_utilizator', 'id_utilizator');
   }
}
