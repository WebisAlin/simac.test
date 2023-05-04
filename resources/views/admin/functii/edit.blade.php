@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
         @csrf
         <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_functie' value='".$functie->id_functie."' />";
         }?>
         <div class="form-group">
            <label>Nume functie</label>
            <input type='text' value='<?=($action=='modifica'?$functie->nume_functie:'')?>' class='form-control' name='nume_functie' placeholder='Nume functie'>
         </div>
         <input type='submit' class='btn btn-primary btn-lg btn-fix' value='<?=($action=='modifica'?'Modifica':'Adauga')?>' />
      </form>
   </div>
</div>
@endsection
