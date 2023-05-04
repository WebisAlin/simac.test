@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post'  id='formMutareValoareGrant' action="<?=$actionForm?>" enctype="multipart/form-data">
        @csrf
        <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_grant_mutare_valoare' value='".$mutare->id_grant_mutare_valoare."' />";
        }?>
        <input type='hidden' name='id_grant' value='<?=$id_grant?>' />
        
        <div class="form-group">
            <label>Cadru didactic sursa <span class="required">*</span></label>
            <select name="id_cd_sursa" class="form-control" required>
                <option value="">Selecteaza cadrul didactic sursa</option>
                @foreach($autori_utcn as $autor)
                    <option <?=(($action=="modifica" && $autor->id_cd==$mutare->id_cd_sursa)  || (old('id_cd_sursa')==$autor->id_cd)?'selected':'')?> value="{{$autor->id_cd}}">{{$autor->cd->nume_cd}} {{$autor->cd->prenume_cd}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Cadru didactic destinatie <span class="required">*</span></label>
            <select name="id_cd_destinatie" class="form-control" required>
                <option value="">Selecteaza cadrul didactic destinatie</option>
                @foreach($autori_utcn as $autor)
                    <option <?=(($action=="modifica" && $autor->id_cd==$mutare->id_cd_destinatie) || (old('id_cd_destinatie')==$autor->id_cd)?'selected':'')?> value="{{$autor->id_cd}}">{{$autor->cd->nume_cd}} {{$autor->cd->prenume_cd}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Valoare <span class="required">*</span></label>
            <input type='number' step="any" max="" required value='<?=($action=='modifica'?$mutare->valoare_mutata:old('valoare_mutata'))?>' class='form-control' name='valoare_mutata' placeholder='Valoare'>
        </div>
        <div class="form-group">
            <label>Cerere <span class="required">*</span></label>
            <input type='text' required value='<?=($action=='modifica'?$mutare->nr_cerere_mutare:old('nr_cerere_mutare'))?>' class='form-control' name='nr_cerere_mutare' placeholder='Numar cerere'>
        </div>
        <span type='button' onclick="mesajAddMutare()" class='btn btn-primary btn-lg'><?=($action=='modifica'?'Modifica':'Adauga')?></span>
      </form>
   </div>
</div>
@endsection
@push('javascript')

@endpush