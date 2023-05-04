@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
         @csrf
         <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_cd' value='".$cadruDidactic->id_cd."' />";
         }?>
         <div class="form-group">
            <label>Nume cadru didactic</label>
            <input type='text' value='<?=($action=='modifica'?$cadruDidactic->nume_cd:'')?>' class='form-control' name='nume_cd' placeholder='Nume cadru didactic' required>
         </div>
         <div class="form-group">
            <label>Prenume cadru didactic</label>
            <input type='text' value='<?=($action=='modifica'?$cadruDidactic->prenume_cd:'')?>' class='form-control' name='prenume_cd' placeholder='Prenume cadru didactic' required>
         </div>
         <div class="form-group">
            <label>Email cadru didactic</label>
            <input type='email' value='<?=($action=='modifica'?$cadruDidactic->email_cd:'')?>' class='form-control' name='email_cd' placeholder='Email cadru didactic' required>
         </div>
         <div class="form-group">
            <label>Telefon cadru didactic</label>
            <input type='text' value='<?=($action=='modifica'?$cadruDidactic->telefon_cd:'')?>' class='form-control' name='telefon_cd' placeholder='Telefon cadru didactic' required>
         </div>
         <div class="form-group">
            <label>Functie cadru didactic</label>
            <select name="id_functie" class="form-control" aria-label="Default select example" required>
                  <option value="">Selectează functie</option>
                  @foreach($functii as $value)
                  <option value="{{ $value->id_functie }}"<?=($action=='modifica' && $cadruDidactic->id_functie == $value->id_functie ?'selected':'')?>>{{ $value->nume_functie }}</option>
                  @endforeach
            </select>
         </div>
         <div class="form-group">
            <label>Semnatura cadru didactic</label>
            <input type='file' value='<?=($action=='modifica'?$cadruDidactic->semnatura_cd:'')?>' accept="image/png" class='form-control' name='semnatura_cd' placeholder='Semnatura cadru didactic'>
            <label for="cc-name" class="control-label mb-1"><?=($action=='modifica'?'<small> (Utilizati acest camp numai daca doriti sa schimbati semnatura.)</small>':'')?></label>
            @if($action=='modifica' && $cadruDidactic->semnatura_cd) 
               <br><img class="imgProfile" src="/uploads/semnatura_cd/{{ $cadruDidactic->semnatura_cd }}"> 
            @endif
         </div>
         <div class="form-group">
            <label>UT</label>
            <input type="checkbox" <?=($action=='modifica' && $cadruDidactic->ut==1?'checked':'')?> name="ut" value="1" class="mt-3">
         </div>
         <div class="form-group">
            <label>Universitate cadru didactic</label>
            <select name="id_universitate" class="form-control" aria-label="Default select example" required>
                  <option value="">Selectează uiversitate</option>
                  @foreach($universitati as $value)
                  <option value="{{ $value->id_universitate  }}"<?=($action=='modifica' && $cadruDidactic->id_universitate == $value->id_universitate  ?'selected':'')?>>{{ $value->nume_universitate }}</option>
                  @endforeach
            </select>
         </div>
         <div class="form-group">
            <label>Facultate cadru didactic</label>
            <select name="id_facultate" class="form-control" aria-label="Default select example" required>
                  <option value="">Selectează facultate</option>
                  @foreach($facultati as $value)
                  <option value="{{ $value->id_facultate }}"<?=($action=='modifica' && $cadruDidactic->id_facultate == $value->id_facultate ?'selected':'')?>>{{ $value->nume_facultate }}</option>
                  @endforeach
            </select>
         </div>
         <div class="form-group">
            <label>Departament cadru didactic</label>
            <select name="id_departament" class="form-control" aria-label="Default select example" required>
                  <option value="">Selectează departament</option>
                  @foreach($departamnete as $value)
                  <option value="{{ $value->id_departament }}"<?=($action=='modifica' && $cadruDidactic->id_departament == $value->id_departament ?'selected':'')?>>{{ $value->nume_departament }}</option>
                  @endforeach
            </select>
         </div>
         <div class="form-group">
            <label>Parola cadru didactic <?=($action=='modifica'?' (Completeaza acest camp doar daca doresti schimbarea parolei)':'')?></label>
            <input type='password' value='' class='form-control' name='password' placeholder='Parola cadru didactic' <?=($action!='modifica'?'required':'')?>>
         </div>
         <input type='submit' class='btn btn-primary btn-lg btn-fix' value='<?=($action=='modifica'?'Modifica':'Adauga')?>' />
      </form>
   </div>
</div>
@endsection
