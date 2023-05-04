@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
         @csrf
         <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_utilizator' value='".$utilizatorActual->id_utilizator."' />";
         }?>
         <div class="form-group">
            <label>Nume <span class="required">*</span></label>
            <input type='text' value='<?=($action=='modifica'?$utilizatorActual->nume_utilizator:'')?>' class='form-control' name='nume_utilizator' placeholder='Nume'>
         </div>
         <div class="form-group">
            <label>Prenume</label>
            <input type='text' value='<?=($action=='modifica'?$utilizatorActual->prenume_utilizator:'')?>' class='form-control' name='prenume_utilizator' placeholder='Prenume'>
         </div>
         <div class="form-group">
            <label>Email <span class="required">*</span></label>
            <input type='text' value='<?=($action=='modifica'?$utilizatorActual->email_utilizator:'')?>' class='form-control' name='email_utilizator' placeholder='Email'>
         </div>
         @if($action=='adauga' || !$utilizatorActual->admin)
            <div class="form-group">
               <label>Rol <span class="required">*</span></label>
               <select class="form-control" required name="id_rol">
                  <option value="">Selecteaza rol</option>
                  @foreach($roluri as $rol)
                     <option value="{{$rol->id_rol}}" <?=($action=='modifica' && $utilizatorActual->id_rol==$rol->id_rol?'selected':'')?>>{{$rol->nume_rol}}</option>
                  @endforeach
               </select>
            </div>
         @endif
         <div class="form-group">
            <label for="cc-name" class="control-label mb-1">Parola <?=($action=='adauga'? '<span class="required">*</span>':'')?></label>
            <label for="cc-name" class="control-label mb-1"><?=($action=='modifica'?'<small> (Completează acest camp doar daca doresti modificarea parolei actuale.)</small>':'')?></label>
            <input  value="" autocomplete="off" name="password" type="password" class="form-control cc-name valid" data-val="true"  aria-required="true" aria-invalid="false" aria-describedby="cc-name-error">
            <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
         </div>
         <div class="form-group">
            <label for="cc-name" class="control-label mb-1">Avatar</label>
            <label for="cc-name" class="control-label mb-1"><?=($action=='modifica'?'<small> (Utilizati acest camp numai daca doriti sa schimbati fotografia de profil curenta.)</small>':'')?></label>
            @if($action=='modifica' && $utilizatorActual->avatar) 
               <br><img class="imgProfile" src="/uploads/img_utilizatori/{{ $utilizatorActual->avatar }}"> 
            @endif
            <br><input value="<?=($action=='modifica'?$utilizatorActual->avatar:'')?>" name="avatar" accept="image/png, image/jpeg, image/jpg" type="file" class="formInput" placeholder="Avatar">
         </div>
         <input type='submit' class='btn btn-primary btn-lg btn-fix' value='<?=($action=='modifica'?'Modifica':'Adauga')?>' />
      </form>
   </div>
</div>
@endsection
