@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
         @csrf
         <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_pagina' value='".$paginaActuala->id_pagina."' />";
         }?>
         <div class="form-group">
            <label>Titlu</label>
            <input type='text' value='<?=($action=='modifica'?$paginaActuala->nume_pagina:'')?>' class='form-control' name='nume_pagina' placeholder='Titlu pagina'>
         </div>
         @if($action=='modifica')
            <div class="form-group">
               <label>Slug</label>
               <input type="text" name="slug_pagina" class="form-control" value="<?=($action=='modifica' ? $paginaActuala->slug_pagina : '')?>" placeholder="Slug pagina">
            </div>
         @endif
         <div class="form-group">
            <label>Descriere</label>
            <textarea rows="3" name="descriere_pagina"  class="form-control ckeditor"><?=($action=='modifica'? $paginaActuala->descriere_pagina : '')?></textarea>
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
