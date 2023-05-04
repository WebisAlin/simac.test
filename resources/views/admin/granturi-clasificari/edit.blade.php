@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
         @csrf
         <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_grant_clasificare' value='".$grant_clasificare ->id_grant_clasificare."' />";
         }?>
        <div class="form-group">
            <label>Nume clasificare</label>
            <input type='text' required value='<?=($action=='modifica'?$grant_clasificare ->nume_grant_clasificare:'')?>' class='form-control' name='nume_grant_clasificare' placeholder='Nume clasificare grant'>
         </div>
        <div class="form-group">
            <label>Valoare grant cu autori straini</label>
            <input type='number' required step="any" value='<?=($action=='modifica'?$grant_clasificare ->valoare_straini_da:'')?>' class='form-control' name='valoare_straini_da' placeholder='Valoare grant cu autori straini'>
         </div>
        <div class="form-group">
            <label>Valoare grant fara autori straini</label>
            <input type='number'required  step="any" value='<?=($action=='modifica'?$grant_clasificare ->valoare_straini_nu:'')?>' class='form-control' name='valoare_straini_nu' placeholder='Valoare grant fara autori straini'>
         </div>
         <input type='submit' class='btn btn-primary btn-lg btn-fix' value='<?=($action=='modifica'?'Modifica':'Adauga')?>' />
      </form>
   </div>
</div>
@endsection
