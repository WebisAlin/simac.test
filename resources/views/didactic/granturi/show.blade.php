@extends('layouts.didactic')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body rezumat-proiect">
      <div class="form-group">
         <label>Titlu grant</label>
         <?=$grant->titlu_grant?>
      </div>
      <div class="form-group">
         <label>Numar grant</label>
         <?=$grant->nr_grant?>
      </div>
      <div class="form-group">
         <label>Publicatie grant</label>
         <?=$grant->publicatie_grant?>
      </div>
      <div class="form-group">
         <label>Detalii grant</label>
         <?=$grant->detalii_grant?>
      </div>
      <div class="form-group">
         <label>Data publicare</label>
         <?=date('d-m-Y', strtotime($grant ->data_publicare_grant))?>
      </div>
      <div class="form-group">
         <label>Autor UTCN depunere cerere</label>
         <?=$grant->cd->nume_cd." ".$grant->cd->prenume_cd?>
      </div>
      <div class="form-group">
         <label>Cerere</label>
         conform cerere nr. <?=($grant->id_grant_cerere?$grant->id_grant_cerere:$grant->id_grant_cerere_custom." (externa)")?>
      </div>
      <div class="form-group">
         <label>Clasificare grant</label>
         <?=$grant->grant_clasificare->nume_grant_clasificare?>
      </div>
      <div class="form-group">
         <label>Autori straini</label>
         <?=($grant->autori_straini?'Da':'Nu')?>
      </div>
      <div class="form-group">
         <label>Autori UTCN</label>
         <?php
         if(count($autori_utcn)){
            foreach($autori_utcn as $autor_utcn){
               echo '<span>'.$autor_utcn->cd->nume_cd.' '.$autor_utcn->cd->prenume_cd.'</span><br>';
            }
         }
         ?>
      </div>
      <div class="form-group">
         <label>Autori externi</label>
         <?php
         if(count($autori_externi)){
            foreach($autori_externi as $autor_extern){
               echo '<span>'.$autor_extern.'</span><br>';
            }
         }else{
            echo '<span>-</span><br>';
         }
         ?>
      </div>
      <div class="form-group">
         <label>Valoare UTCN</label>
         <?=$grant->valoare_utcn?> lei
      </div>
      <div class="form-group">
         <label>Valoare cota parte</label>
         <?=$grant->valoare_cota_parte?> lei
      </div>
      <div class="form-group">
         <label>Data expirare grant</label>
         <?=date('d-m-Y', strtotime($grant->data_expirare_grant))?>
      </div>
   </div>
</div>
@endsection


