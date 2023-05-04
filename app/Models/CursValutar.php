<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursValutar extends Model
{
   use HasFactory;
   protected $table = 'cursuri_valutare';
   protected $primaryKey = 'id_curs';

}
