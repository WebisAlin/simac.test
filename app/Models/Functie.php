<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Functie extends Model
{
   use HasFactory;
   protected $table = 'functii';
   protected $primaryKey = 'id_functie';

}
