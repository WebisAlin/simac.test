@extends('layouts.admin')
@section('content')
<div class="card"> 
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
        @csrf
        <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_proiect_notificare' value='".$notificare_proiect->id_proiect_notificare."' />";
        }?>
        <input type='hidden' name='id_proiect' value='<?=$id_proiect?>' />
        <div class="form-group">
            <label>Text</label>
            <textarea rows="3" class='form-control ckeditor' name='text_notificare_proiect' placeholder='Text notificare'><?=($action=='modifica'?$notificare_proiect->text_notificare_proiect:'')?></textarea>
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