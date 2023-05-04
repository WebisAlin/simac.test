<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrantClasificare extends Model
{
   protected $table = 'granturi_clasificari';
   protected $primaryKey = 'id_grant_clasificare';

    public function granturi(){
        return $this->hasMany(Grant::class, 'id_grant_clasificare','id_grant_clasificare');
    }

}
