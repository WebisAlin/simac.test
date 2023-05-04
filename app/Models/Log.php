<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
   protected $table = 'loguri';
   protected $primaryKey = 'id_log';

   public function utilizator(){
      return $this->belongsTo(Utilizator::class, 'id','id_utilizator');
   }

   public function user(){
      return $this->belongsTo(User::class, 'id');
   }

   public function getRealUser(){
      if($this->tip_user=='utilizator' || $this->tip_user=='admin'){
         $user=$this->utilizator;
         $user->name=$user->nume_utilizator." ".$user->prenume_utilizator;
         $user->email=$user->email_utilizator;
      }else{
         $user=$this->user;
      }
      return $user;
   }
}
