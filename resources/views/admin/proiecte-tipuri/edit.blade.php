@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
         @csrf
         <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_tip_proiect' value='".$tip_proiect->id_tip_proiect."' />";
         }?>
         <div class="form-group">
            <label>Tip proiect</label>
            <input type='text' value='<?=($action=='modifica'?$tip_proiect->tip_proiect:'')?>' class='form-control' name='tip_proiect' placeholder='Tip proiect'>
         </div>
         <div class="form-group">
            <label>Tip proiect parinte</label>
            <select name="parinte" class="form-control">
                <option value="">Selecteaza parinte</option>
                @foreach($tipuri_proiecte as $tip_proiect_all)
                    <option  <?=($action=='modifica' && $tip_proiect->parinte==$tip_proiect_all->id_tip_proiect?'selected':'')?> value="{{$tip_proiect_all->id_tip_proiect}}">{{$tip_proiect_all->tip_proiect}}</option>
                @endforeach
            </select>
         </div>
         <input type='submit' class='btn btn-primary btn-lg btn-fix' value='<?=($action=='modifica'?'Modifica':'Adauga')?>' />
      </form>
   </div>
</div>
@endsection
