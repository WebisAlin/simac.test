<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrantAutorUtcn extends Model
{
   protected $table = 'granturi_autori_utcn';
   protected $primaryKey = 'id_grant_autor_utcn';

    public function grant(){
        return $this->belongsTo(Grant::class, 'id_grant','id_grant');
    }   

    public function cd(){
        return $this->belongsTo(CadruDidactic::class, 'id_cd','id_cd');
    }   

}
