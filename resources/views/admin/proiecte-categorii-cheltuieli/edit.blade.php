@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
         @csrf
         <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_proiect_categorie_cheltuieli' value='".$categorie_cheltuieli->id_proiect_categorie_cheltuieli."' />";
         }?>
         <div class="form-group">
            <label>Nume categorie cheltuieli</label>
            <input type='text' value='<?=($action=='modifica'?$categorie_cheltuieli->nume_categorie_cheltuieli:'')?>' class='form-control' name='nume_categorie_cheltuieli' placeholder='Nume categorie cheltuiala'>
         </div>
         <div class="form-group">
            <label>Categorie cheltuieli parinte</label>
            <select name="parinte" class="form-control">
                <option value="">Selecteaza parinte</option>
                @foreach($categorii_cheltuieli as $categorie_cheltuieli_all)
                    <option  <?=($action=='modifica' && $categorie_cheltuieli->parinte==$categorie_cheltuieli_all->id_proiect_categorie_cheltuieli?'selected':'')?> value="{{$categorie_cheltuieli_all->id_proiect_categorie_cheltuieli}}">{{$categorie_cheltuieli_all->nume_categorie_cheltuieli}}</option>
                @endforeach
            </select>
         </div>
         <input type='submit' class='btn btn-primary btn-lg btn-fix' value='<?=($action=='modifica'?'Modifica':'Adauga')?>' />
      </form>
   </div>
</div>
@endsection
