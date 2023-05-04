@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
         @csrf
         <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_limba' value='".$limba->id_limba."' />";
         }?>
         <div class="form-group">
            <label>Acronim limba</label>
            <input type='text' value='<?=($action=='modifica'?$limba->limba:'')?>' class='form-control' name='limba' placeholder='Acronim limba'>
         </div>
         <div class="form-group">
            <label>Denumire limba</label>
            <input type='text' value='<?=($action=='modifica'?$limba->nume_limba:'')?>' class='form-control' name='nume_limba' placeholder='Denumire limba'>
         </div>
         <input type='submit' class='btn btn-primary btn-lg btn-fix' value='<?=($action=='modifica'?'Modifica':'Adauga')?>' />
      </form>
   </div>
</div>
@endsection
