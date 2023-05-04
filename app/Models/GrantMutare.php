<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrantMutare extends Model
{
   protected $table = 'granturi_mutari_valori';
   protected $primaryKey = 'id_grant_mutare_valoare';

    public function utilizator(){
        return $this->belongsTo(Utilizator::class, 'id_utilizator','id_utilizator');
    }   

    public function grant(){
        return $this->belongsTo(Grant::class, 'id_grant','id_grant');
    }  

    public function cd_sursa(){
        return $this->belongsTo(CadruDidactic::class, 'id_cd_sursa','id_cd');
    }  

    public function cd_destinatie(){
        return $this->belongsTo(CadruDidactic::class, 'id_cd_destinatie','id_cd');
    } 
        
}
