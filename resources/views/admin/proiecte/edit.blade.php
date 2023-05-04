@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
         @csrf
         <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_proiect' value='".$proiect->id_proiect."' />";
         }?>
         <div class="form-group">
            <label>Denumire proiect <span class="required">*</span></label>
            <input type='text' value='<?=($action=='modifica'?$proiect->denumire_proiect:'')?>' class='form-control' name='denumire_proiect' placeholder='Denumire proiect'>
         </div>
         <div class="form-group">
            <label>Cod proiect</label>
            <input type='text' value='<?=($action=='modifica'?$proiect->cod_proiect:'')?>' class='form-control' name='cod_proiect' placeholder='Cod proiect'>
         </div>
         <div class="form-group">
            <label>Director de proiect <span class="required">*</span></label>
            <input type="hidden" name="id_cd" required value='<?=($action=='modifica'?$proiect->id_cd:'')?>'/>
            <input type="text" required autocomplete="off" data-tip="cadre-didactice" value="<?=($action=='modifica'?$proiect->director->nume_cd." ".$proiect->director->prenume_cd:'')?>"  class="form-control cauta"  placeholder="Director de proiect" >
            <ul class="rezultateCautare"></ul>
        </div>
        <div class="form-group">
            <label>Tip proiect <span class="required">*</span></label>
            <select name="id_tip_proiect" required class="form-control">
                <option value="">Selecteaza tip proiect</option>
                @foreach($tipuri_proiecte as $id_tip_proiect=>$tip_proiect_nume)
                    <option  <?=($action=='modifica' && $proiect->id_tip_proiect==$id_tip_proiect?'selected':'')?> value="{{$id_tip_proiect}}">{{$tip_proiect_nume}}</option>
                @endforeach
            </select>
         </div>
         <div class="form-group">
            <label>Moneda</label>
            <select name="moneda_proiect" class="form-control">
               <option value="RON" <?=($action=='modifica'&& $proiect->moneda_proiect=='RON'?'selected':'')?>>RON</option>
               <option value="EUR" <?=($action=='modifica'&& $proiect->moneda_proiect=='EUR'?'selected':'')?>>EUR</option>
            </select>
         </div>
         <div class="form-group">
            <label>Valoare <span class="required">*</span></label>
            <input type='number' step="any" required value='<?=($action=='modifica'?$proiect->valoare_proiect:'')?>' class='form-control' name='valoare_proiect' placeholder='Valoare'>
         </div>
         <div class="form-group">
            <label>Data inceput <span class="required">*</span></label>
            <input type='text' value='<?=($action=='modifica'?date('d-m-Y', strtotime($proiect->data_inceput_proiect)):'')?>' required class='form-control datepicker' name='data_inceput_proiect' placeholder='Data inceput'>
         </div>
         <div class="form-group">
            <label>Data final <span class="required">*</span></label>
            <input type='text' value='<?=($action=='modifica'?date('d-m-Y', strtotime($proiect->data_final_proiect)):'')?>' required class='form-control datepicker' name='data_final_proiect' placeholder='Data final'>
         </div>
         <div class="form-group">
            <label>Nr. contract</label>
            <input type='text' value='<?=($action=='modifica'?$proiect->nr_contract:'')?>' class='form-control' name='nr_contract' placeholder='Numar contract'>
         </div>
         <div class="form-group">
            <label>Pagina web</label>
            <input type='text' value='<?=($action=='modifica'?$proiect->pagina_web:'')?>' class='form-control' name='pagina_web' placeholder='Pagina web'>
         </div>
         <input type='submit' class='btn btn-primary btn-lg btn-fix' value='<?=($action=='modifica'?'Modifica':'Adauga')?>' />
      </form>
   </div>
</div>
@endsection
@push('javascript')
<script>
   ClassicEditor
   .create( document.querySelector( ".ckeditor" ), {
      placeholder:'Continut',
      ckfinder: {
         uploadUrl: '{{route('ckeditor.upload').'?_token='.csrf_token()}}'
      },
   })
   .then( editor => {
      editor.isReadOnly = true;
   } )
   .catch( error => {
   });
</script>
@endpush