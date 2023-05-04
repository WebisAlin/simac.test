<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeniuElement extends Model
{
   use HasFactory;
   protected $table = 'meniuri_elemente';
   protected $primaryKey = 'id_element_meniu';

   public function meniu()
    {
        return $this->belongsTo(Meniu::class, 'id_meniu', 'id_meniu');
    }

    public function copii(){
        return MeniuElement::where('parinte', $this->id_element_meniu)->get();
    }

    public function utilizator()
   {
       return $this->belongsTo(Utilizator::class, 'id_utilizator', 'id_utilizator');
   }

}
