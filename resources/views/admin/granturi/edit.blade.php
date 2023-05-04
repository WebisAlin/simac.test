@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
         @csrf
         <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_grant_clasificare' value='".$grant ->id_grant_clasificare."' />";
         }?>
         <div class="form-group">
            <label>Titlu grant <span class="required">*</span></label>
            <input type='text' value='<?=($action=='modifica'?$grant ->titlu_grant:'')?>' class='form-control' name='titlu_grant' placeholder='Titlu grant'>
         </div>
         <div class="form-group">
            <label>Numar grant <span class="required">*</span></label>
            <input type='number' value='<?=($action=='modifica'?$grant ->nr_grant  :'')?>' class='form-control' name='nr_grant' placeholder='Numar grant'>
         </div>
         <div class="form-group">
            <label>Publicatie grant</label>
            <input type='text' autocomplete="off" value='<?=($action=='modifica'?$grant ->publicatie_grant:'')?>' class='form-control' name='publicatie_grant' placeholder='Publicatie grant'>
         </div>
         <div class="form-group">
            <label>Detalii grant</label>
            <input type='text' autocomplete="off" value='<?=($action=='modifica'?$grant ->detalii_grant:'')?>' class='form-control' name='detalii_grant' placeholder='Detalii grant'>
         </div>
         <div class="form-group">
            <label>Data publicare</label>
            <input type='text' autocomplete="off" value='<?=($action=='modifica'?date('d-m-Y', strtotime($grant ->data_publicare_grant)):'')?>' class='form-control datepicker' name='data_publicare_grant' placeholder='Data publicarii'>
         </div>
         <div class="form-group">
            <label>Autor UTCN depunere cerere <span class="required">*</span></label>
            <input type="hidden" name="id_cd" required value='<?=($action=='modifica'?$grant->id_cd:'')?>'/>
            <input type="text" required autocomplete="off" data-tip="cadre-didactice" value="<?=($action=='modifica'?$grant->cd->nume_cd." ".$grant->cd->prenume_cd:'')?>"  class="form-control cauta"  placeholder="Nume si prenume autor UTCN depunere cerere" >
            <ul class="rezultateCautare"></ul>
         </div>
         <div class="form-group">
            <label>Cerere <span class="required">*</span></label>
            <select name="id_grant_cerere" required class="form-control">
               <option value="">Selecteaza cerere</option>
               @if(isset($cereri_autor_depunere))
                  @foreach($cereri_autor_depunere as $cerere)
                     <option value="{{$cerere->id_grant_cerere}}" <?=($cerere->id_grant_cerere==$grant->id_grant_cerere?'selected':'')?>>conform cerere nr. {{$cerere->id_grant_cerere}}</option>
                  @endforeach
               @endif
               <option value="0" {{($action=='modifica' && $grant->id_grant_cerere==0?'selected':'')}}>Cerere externa</option>
            </select>
            <input type='number' value='<?=($action=='modifica'?$grant->id_grant_cerere_custom:'')?>' class='form-control mt-1 {{($action=="modifica" && $grant->id_grant_cerere==0?"":"d-none")}}' name='id_grant_cerere_custom' placeholder='Numar cerere externa'>
         </div>
         <div class="form-group">
            <label>Clasificare grant <span class="required">*</span></label>
            <select class="form-control" required name="id_grant_clasificare">
               <option value="">Selecteaza clasificare</option>
               @foreach($granturi_clasificari as $grant_clasificare)
                  <option value="{{$grant_clasificare->id_grant_clasificare}}" <?=($action=='modifica' && $grant->id_grant_clasificare==$grant_clasificare->id_grant_clasificare?'selected':'')?>>{{$grant_clasificare->nume_grant_clasificare}}</option>
               @endforeach
            </select>
         </div>
         <div class="form-group">
            <label>Autori straini <span class="required">*</span></label>
            <label class="custom-control custom-radio">
               <input type="radio" class="custom-control-input" name="autori_straini" value="0" <?=(($action=='adauga') || ($action=='modifica' && $grant->autori_straini==0)?'checked':'')?>>
               <span class="custom-control-label">Nu</span>
            </label>
            <label class="custom-control custom-radio">
               <input type="radio" class="custom-control-input" name="autori_straini" value="1" <?=($action=='modifica' && $grant->autori_straini==1?'checked':'')?>>
               <span class="custom-control-label">Da</span>
            </label>
         </div>
         <div class="form-group">
            <div class="boxMultiplicare">
            <label class="mr-4">Autori UTCN</label><span class="btn btn-sm btn-success btnAdd mt-2 mb-1"><i class="fas fa-plus"></i></span>
               <div class="tabelaArticole contentTabela form-control">
                  <div class="randTabela mb-2 d-none">
                  <div class="row">
                        <div class="col-sm-5 col padding10">
                           <input type="hidden" name="id_autor_utcn[]" value=''/>
                           <input type="text" autocomplete="off" data-tip="cadre-didactice" value="" class="form-control cauta"  placeholder="Nume si prenume" >
                           <ul class="rezultateCautare"></ul>
                        </div>
                        <div class="col-sm-3 col padding10">
                           <input type="text" autocomplete="off" name="valoare_cota_parte_autor[]" class="form-control" placeholder="Valoare cota parte" >
                        </div>
                        <div class="col-sm-3 col padding10">
                           <input type="text" autocomplete="off" name="valoare_ramasa_autor[]" class="form-control" placeholder="Valoare ramasa" >
                        </div>
                        <div class="col-sm-1 col padding10 text-center my-auto">
                           <span class="btn btn-sm btn-danger btnRemoveRand"><i class="fas fa-times-circle"></i></span>
                        </div>
                     </div>
                  </div>
                  @if(isset($autori_utcn_grant) && count($autori_utcn_grant))
                     @foreach($autori_utcn_grant as $autor_utcn_grant)
                        <div class="randTabela mb-2">
                            <div class="row">
                                <div class="col-sm-5 col padding10">
                                    <input type="hidden" name="id_grant_autor_utcn[]" value='<?=($action=='modifica'?$autor_utcn_grant->id_grant_autor_utcn:'')?>'/>
                                    <input type="hidden" name="id_autor_utcn[]" required value='<?=($action=='modifica'?$autor_utcn_grant->id_cd:'')?>'/>
                                    <input type="text" required autocomplete="off" data-tip="cadre-didactice" value="<?=($action=='modifica'?$autor_utcn_grant->cd->nume_cd." ".$autor_utcn_grant->cd->prenume_cd:'')?>"  class="form-control cauta"  placeholder="Nume si prenume" >
                                    <ul class="rezultateCautare"></ul>
                                </div>
                                <div class="col-sm-3 col padding10">
                                    <input type="text" autocomplete="off" value="{{($action=='modifica'?$autor_utcn_grant->valoare_cota_parte_autor:'')}}" name="valoare_cota_parte_autor[]" class="form-control" placeholder="Valoare cota parte" >
                                 </div>
                                 <div class="col-sm-3 col padding10">
                                    <input type="text" autocomplete="off" name="valoare_ramasa_autor[]" value="{{($action=='modifica'?$autor_utcn_grant->valoare_ramasa_autor:'')}}" class="form-control" placeholder="Valoare ramasa" >
                                 </div>
                                <div class="col-sm-1 col padding10 text-center my-auto">
                                    <span class="btn btn-sm btn-danger btnRemoveRand"><i class="fas fa-times-circle"></i></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                  @else
                     <div class="randTabela mb-2">
                        <div class="row">
                           <div class="col-sm-5 col padding10">
                              <input type="hidden" name="id_autor_utcn[]" value=''/>
                              <input type="text" autocomplete="off" data-tip="cadre-didactice" value="" class="form-control cauta"  placeholder="Nume si prenume" >
                              <ul class="rezultateCautare"></ul>
                           </div>
                           <div class="col-sm-3 col padding10">
                              <input type="text" autocomplete="off" name="valoare_cota_parte_autor[]" class="form-control" placeholder="Valoare cota parte" >
                           </div>
                           <div class="col-sm-3 col padding10">
                              <input type="text" autocomplete="off" name="valoare_ramasa_autor[]" class="form-control" placeholder="Valoare ramasa" >
                           </div>
                           <div class="col-sm-1 col padding10 text-center my-auto">
                              <span class="btn btn-sm btn-danger btnRemoveRand"><i class="fas fa-times-circle"></i></span>
                           </div>
                        </div>
                     </div>
                  @endif
               </div>
            </div>
        </div>
         <div class="form-group">
            <div class="boxMultiplicare">
               <label class="mr-4">Autori externi</label><span class="btn btn-sm btn-success btnAdd mt-2 mb-1"><i class="fas fa-plus"></i></span>
               <div class="tabelaArticole contentTabela form-control">
                  <div class="randTabela mb-2 d-none">
                     <div class="row">
                        <div class="col-sm-11 col padding10">
                           <input name="autori_externi_grant[]" class="form-control" type="text" placeholder="Nume si prenume">
                        </div>
                        <div class="col-sm-1 col padding10 text-center my-auto">
                           <span class="btn btn-sm btn-danger btnRemoveRand"><i class="fas fa-times-circle"></i></span>
                        </div>
                     </div>
                  </div>
                  @if(isset($autori_externi) && count($autori_externi))
                     @foreach($autori_externi as $autor_extern)
                        <div class="randTabela mb-2">
                            <div class="row">
                                <div class="col-sm-11 col padding10">
                                    <input name="autori_externi_grant[]"  class="form-control" value="{{$autor_extern}}" type="text" placeholder="Nume si prenume">
                                </div>
                                <div class="col-sm-1 col padding10 text-center my-auto">
                                    <span class="btn btn-sm btn-danger btnRemoveRand"><i class="fas fa-times-circle"></i></span>
                                </div>
                            </div>

                        </div>
                    @endforeach
                  @else
                     <div class="randTabela mb-2">
                        <div class="row">
                        <div class="col-sm-11 col padding10">
                              <input name="autori_externi_grant[]" class="form-control" type="text" placeholder="Nume si prenume">
                        </div>
                        <div class="col-sm-1 col padding10 text-center my-auto">
                              <span class="btn btn-sm btn-danger btnRemoveRand"><i class="fas fa-times-circle"></i></span>
                        </div>
                        </div>
                     </div>
                  @endif
               </div>
            </div>
        </div>
         <div class="form-group">
            <label>Open access <span class="required">*</span></label>
            <label class="custom-control custom-radio">
               <input type="radio" class="custom-control-input" <?=(($action=='adauga') || ($action=='modifica' && $grant->open_access==0)?'checked':'')?> name="open_access" value="0" >
               <span class="custom-control-label">Nu</span>
            </label>
            <label class="custom-control custom-radio">
               <input type="radio" class="custom-control-input" <?=($action=='modifica' && $grant->open_access==1?'checked':'')?> name="open_access" value="1">
               <span class="custom-control-label">Da</span>
            </label>
         </div>
         <div class="form-group">
            <label>Data expirare grant <span class="required">*</span></label>
            <input type='text' autocomplete="off" required value='<?=($action=='modifica'?date('d-m-Y', strtotime($grant ->data_expirare_grant)):'')?>' class='form-control datepicker' name='data_expirare_grant' placeholder='Data expirare'>
         </div>
         <div class="form-group">
            <label>Calcul valori <span class="btn btn-secondary actualizeazaValoriGranturi btn-sm ml-3">actualizeaza valori</span></label>
            <div class="form-control">
               <div class="row mb-2">
                  <div class="col-sm-2 my-auto">
                     <label>Valoare totala grant (lei)</label>
                  </div>
                  <div class="col-sm-4">
                     <input class="form-control valoare_totala_grant" readonly value="<?=($action=='modifica'?$grant->getValoareGrant($grant->autori_straini) :'')?>">
                  </div>
               </div>
               <div class="row mb-2">
                  <div class="col-sm-2 my-auto">
                     <label>Valoare UTCN (lei)</label>
                  </div>
                  <div class="col-sm-4">
                     <input name="valoare_utcn" class="form-control valoare_utcn" value="<?=($action=='modifica'?$grant->valoare_utcn :'')?>">
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-2 my-auto">
                     <label>Valoare cota parte (lei)</label>
                  </div>
                  <div class="col-sm-4">
                     <input name="valoare_cota_parte" class="form-control valoare_cota_parte" value="<?=($action=='modifica'?$grant->valoare_cota_parte :'')?>">
                  </div>
               </div>
            </div>
         </div>
         <input type='submit' class='btn btn-primary btn-lg btn-fix' value='<?=($action=='modifica'?'Modifica':'Adauga')?>' />
      </form>
   </div>
</div>
@endsection

