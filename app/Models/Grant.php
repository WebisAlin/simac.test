<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
   protected $table = 'granturi';
   protected $primaryKey = 'id_grant';

    public function utilizator(){
        return $this->belongsTo(Utilizator::class, 'id_utilizator','id_utilizator');
    }   

    public function cd(){
        return $this->belongsTo(CadruDidactic::class, 'id_cd','id_cd');
    }  
    
    public function autori_utcn(){
        return $this->hasMany(GrantAutorUtcn::class, 'id_grant','id_grant');
    }  

    public function cerere(){
        return $this->belongsTo(GrantCerere::class, 'id_grant_cerere','id_grant_cerere');
    } 

    public function grant_clasificare(){
        return $this->belongsTo(GrantClasificare::class, 'id_grant_clasificare','id_grant_clasificare');
    } 

    public function getValoareGrant(){
        if($this->autori_straini){
            return $this->grant_clasificare->valoare_straini_da;
        }else{
            return $this->grant_clasificare->valoare_straini_nu;
        }
    }
    
}
