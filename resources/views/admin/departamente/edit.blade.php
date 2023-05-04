@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
         @csrf
         <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_departament' value='".$departament->id_departament."' />";
         }?>
         <div class="form-group">
            <label>Nume departament</label>
            <input type='text' value='<?=($action=='modifica'?$departament->nume_departament:'')?>' class='form-control' name='nume_departament' placeholder='Nume departament'>
         </div>
         <input type='submit' class='btn btn-primary btn-lg btn-fix' value='<?=($action=='modifica'?'Modifica':'Adauga')?>' />
      </form>
   </div>
</div>
@endsection
