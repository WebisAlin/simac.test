@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
        @csrf
        <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_proiect_entitate' value='".$entitate->id_proiect_entitate."' />";
        }?>
        <input type='hidden' name='id_proiect' value='<?=$id_proiect?>' />
        <div class="form-group">
            <label>Universitate</label>
            <input type="hidden" name="id_universitate" required value='<?=($action=='modifica'?$entitate->id_universitate:'')?>'/>
            <input type="text" required autocomplete="off" data-tip="universitati" value="<?=($action=='modifica'?$entitate->universitate->nume_universitate:'')?>"  class="form-control cauta"  placeholder="Universitate" >
            <ul class="rezultateCautare"></ul>
        </div>
        <div class="form-group">
            <label>Rol in cadrul proiectului</label>
            <input type='text' required value='<?=($action=='modifica'?$entitate->rol_entitate:'')?>' class='form-control' name='rol_entitate' placeholder='Rol'>
        </div>
        <div class="form-group">
            <label>Procent alocat</label>
            <div class="input-group mb-3">
                <input type="number" step="any" value='<?=($action=='modifica'?$entitate->procent_alocat_entitate:'')?>' class="form-control" name='procent_alocat_entitate' placeholder="Procent alocat" aria-label="Procent alocat" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">%</span>
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