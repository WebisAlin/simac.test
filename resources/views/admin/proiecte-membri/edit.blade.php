@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
        @csrf
        <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_proiect_membru' value='".$membru->id_proiect_membru."' />";
        }?>
        <input type='hidden' name='id_proiect' value='<?=$id_proiect?>' />
        <div class="form-group">
            <label>Membru</label>
            <input type="hidden" name="id_cd" required value='<?=($action=='modifica'?$membru->id_cd:'')?>'/>
            <input type="text" required autocomplete="off" data-tip="cadre-didactice" value="<?=($action=='modifica'?$membru->cd->nume_cd." ".$membru->cd->prenume_cd:'')?>"  class="form-control cauta"  placeholder="Membru" >
            <ul class="rezultateCautare"></ul>
        </div>
        <div class="form-group">
            <label>Functie in cadrul proiectului</label>
            <input type='text' required value='<?=($action=='modifica'?$membru->functie_membru:'')?>' class='form-control' name='functie_membru' placeholder='Functie membru'>
        </div>
        <div class="form-group">
            <div class="boxMultiplicare">
            <label class="mr-4">Atasamente</label><span class="btn btn-sm btn-success btnAdd mt-2 mb-2"><i class="fas fa-plus"></i></span>
               <div class="tabelaArticole contentTabela form-control">
                <div class="randTabela mb-2 d-none">
                    <div class="row">
                    <div class="col-sm-11 col padding10 nrCrt">
                        <input name="atasamente_membru_proiect[]" class="form-control" type="file">
                    </div>
                    <div class="col-sm-1 col padding10 text-center my-auto">
                        <span class="btn btn-sm btn-danger btnRemoveRand"><i class="fas fa-times-circle"></i></span>
                    </div>
                    </div>
                </div>
                  @if(isset($atasamenteExistente) && count($atasamenteExistente))
                     @foreach($atasamenteExistente as $atasament)
                        <div class="randTabela mb-2">
                            <div class="row">
                                <div class="col-sm-11 col padding10 nrCrt">
                                    <div class="form-control">
                                        <input name="atasamente_existente[]" value="{{$atasament->atasament}}" type="hidden">
                                        <a target="_blank" href="/uploads/atasamente_membri/{{$atasament->atasament}}">{{$atasament->atasament}}</a>
                                    </div>
                                </div>
                                <div class="col-sm-1 col padding10 text-center my-auto">
                                    <span class="btn btn-sm btn-danger btnRemoveRand"><i class="fas fa-times-circle"></i></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                     <div class="randTabela mb-2">
                        <div class="row">
                           <div class="col-sm-11 col padding10 nrCrt">
                              <input name="atasamente_membru_proiect[]" class="form-control" type="file">
                           </div>
                           <div class="col-sm-1 col padding10 text-center my-auto">
                              <span class="btn btn-sm btn-danger btnRemoveRand"><i class="fas fa-times-circle"></i></span>
                           </div>
                        </div>
                     </div>
                  
               </div>
               
            </div>
        </div>
        <input type='submit' class='btn btn-primary btn-lg btn-fix' value='<?=($action=='modifica'?'Modifica':'Adauga')?>' />
      </form>
   </div>
</div>
@endsection
@push('javascript')

@endpush