@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
         @csrf
         <div class="form-group">
            <label>Titlu</label>
            <input type='text'  value='<?=($action=='modifica'?$notificare->titlu_notificare:'')?>' class='form-control' name='titlu_notificare' placeholder='Titlu notificare'>
         </div>
         <div class="form-group">
            <label>Text</label>
            <textarea rows="3"  class='form-control ckeditor' name='text_notificare' placeholder='Text notificare'><?=($action=='modifica'?$notificare->text_notificare:'')?></textarea>
         </div>
         <h6>Destinatari</h6>
         <div class="form-group">
            <label>Trimite notificare catre toti utilizatorii cu rolul selectat</label>
            <select name="id_rol" class="form-control" >
                <option value="">Selecteaza rol</option>
                @foreach($roluri as $rol)
                    <option value="{{$rol->id_rol}}" <?=($action=='modifica' && $notificare->id_rol==$rol->id_rol?'selected':'')?>>{{$rol->nume_rol}}</option>
                @endforeach
                <option value="all" <?=($action=='modifica' && !$notificare->id_rol && !$notificare->id_utilizatori_custom?'selected':'')?>>Toate rolurile</option>

            </select>
        </div>
        <div class="form-group">
            <?php 
               $id_utilizatori_custom=[];
               if($action=='modifica'){
                  if($notificare->id_utilizatori_custom){
                     $id_utilizatori_custom=unserialize($notificare->id_utilizatori_custom);
                  }
               }
            ?>
            <label>sau trimite notificare catre utilizatorii selectati manual</label>
            <select class="form-control select_id_utilizatori_custom"  data-select2target="field-hidden-id_utilizatori_custom" name="id_utilizatori_custom[]"  data-placeholder="Cauta utilizatori" multiple="multiple">
                <option value="">Selecteaza utilizatori</option>
                @if(isset($utilizatori))
                  @foreach($utilizatori as $utilizator)
                     <option <?=(in_array($utilizator->id_utilizator, $id_utilizatori_custom)?'selected':'')?> value="{{$utilizator->id_utilizator}}">{{$utilizator->nume_utilizator}} {{$utilizator->prenume_utilizator}}</option>
                  @endforeach
               @endif
            </select>
        </div>
        @if($action=='adauga')
            <input type='submit' class='btn btn-primary btn-lg btn-fix' value='<?=($action=='modifica'?'Trimite':'Trimite')?>' />
        @endif
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