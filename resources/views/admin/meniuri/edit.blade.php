@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
         @csrf
         <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_meniu' value='".$meniu->id_meniu."' />";
         }?>
         <div class="form-group">
            <label>Denumire meniu</label>
            <input type='text' value='<?=($action=='modifica'?$meniu->nume_meniu:'')?>' class='form-control' name='nume_meniu' placeholder='Denumire meniu'>
         </div>
         <div class="form-group">
            <label>Rol</label>
            <select class="form-control" required name="id_rol">
               <option value="">Selecteaza rol</option>
               @foreach($roluri as $rol)
                  <option value="{{$rol->id_rol}}" <?=($action=='modifica' && $meniu->id_rol==$rol->id_rol?'selected':'')?>>{{$rol->nume_rol}}</option>
               @endforeach
            </select>
         </div>
         <input type='submit' class='btn btn-primary btn-lg mt-1 mb-1' value='<?=($action=='modifica'?'Modifica':'Adauga')?>' />
      </form>
      <hr>
      @if($action=='modifica')
         <div class="mt-3">
            <div class="row">
               <div class="col-sm-4">
                  <label>Elemente meniu</label>
               </div>
               <div class="col-sm-8">
                  <label>Structura meniu</label>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <ul class="accordion-meniu accordionjs m-0" data-active-index="false">
                     <li class="acc_section">
                        <div class="acc_head"><h3>Gestiuni</h3></div>
                        <div class="acc_content" style="display: none;" method="POST">
                           <form method="POST">
                              @if(count($gestiuni))
                                 <ul class="list-unstyled">
                                    @foreach($gestiuni as $gestiune)
                                       <li class="bb-0">
                                          <label class="custom-control custom-checkbox">
                                             <input type="checkbox" class="custom-control-input" name="elemente" value="{{slugify($gestiune)}}">
                                             <span class="custom-control-label">{{$gestiune}}</span>
                                          </label>
                                       </li>
                                    @endforeach
                                 </ul>
                              @endif
                              <div class="text-right">
                                 <input type="hidden" name="tip" value="1">
                                 <input type="submit" class='btn btn-primary mt-2 mb-1 adaugaInMeniu btn-sm' value="Adauga in meniu">
                              </div>
                           </form>
                        </div>
                     </li>
                     <li class="acc_section">
                        <div class="acc_head"><h3>Nomenclatoare</h3></div>
                        <div class="acc_content" style="display: none;" method="POST">
                           <form method="POST">
                              @if(count($nomenclatoare))
                                 <ul class="list-unstyled">
                                    @foreach($nomenclatoare as $nomenclator)
                                       <li class="bb-0">
                                          <label class="custom-control custom-checkbox">
                                             <input type="checkbox" class="custom-control-input" name="elemente" value="{{slugify($nomenclator)}}">
                                             <span class="custom-control-label">{{$nomenclator}}</span>
                                          </label>
                                       </li>
                                    @endforeach
                                 </ul>
                              @endif
                              <div class="text-right">
                                 <input type="hidden" name="tip" value="1">
                                 <input type="submit" class='btn btn-primary mt-2 mb-1 adaugaInMeniu btn-sm' value="Adauga in meniu">
                              </div>
                           </form>
                        </div>
                     </li>
                     <li class="acc_section">
                        <div class="acc_head"><h3>Legaturi personalizate</h3></div>
                        <div class="acc_content" style="display: none;">
                           <form method="POST">
                              <input type="text" class="form-control" placeholder="Eticheta navigare" name="eticheta_meniu">
                              <input type="text" class="form-control mt-1" placeholder="URL" name="link_meniu">
                              <div class="text-right">
                                 <input type="submit" class='btn btn-primary btn-sm mt-2 mb-1 adaugaInMeniu' value="Adauga in meniu">
                              </div>
                           </form>
                        </div>
                     </li>
                  </ul>
               </div>
               <div class="col-sm-8">
                  <div class="colMeniu">
                     <ol class="panel-group divMeniu" id="accordion_meniu" role="tablist" aria-multiselectable="true">

                     </ol>
                  </div>
               </div>
            </div>
         </div>
      @endif
   </div>
</div>
@endsection
@push('javascript')
   <script>
      $(function(e) {
         $(".accordion-meniu").accordionjs();
      
         @if($action=='modifica')
            $.ajaxSetup({
               headers: {
                  'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
               }
            });
            $.ajax({
               type: 'POST',
               url: '/ajax/ajaxIncarcareMeniuAdmin',
               data:{
                  'id_meniu':<?=$meniu->id_meniu?>
               },
               success: function(response)
               {
                  $('.divMeniu').html(response);
               }
            });
         @endif

         $('.divMeniu').nestedSortable({
            handle:'div',
            items:'li',
            maxLevels: 2,
            opacity: .6,
            tolerance:1,
            update: function (event, ui) {
               var vecin_anterior=ui.item.prev().attr('data-previndex');
               var vecin_urmator=ui.item.next().attr('data-previndex');

               // fix if primul || ultimul element
               if (typeof vecin_anterior === "undefined") {vecin_anterior=0;}
               if (typeof vecin_urmator === "undefined") {vecin_urmator=0;}

               //preluare element pe care il mutam
               id_elem_meniu = ui.item.attr('data-id');
               
               // preluare parinte
               id_parinte=ui.item.parent().parent().attr('data-id');
               $.ajaxSetup({
                  headers: {
                     'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                  }
               });
               $.ajax({
                  type: 'POST',
                  url: '/ajax/ajaxUpdateOrdineMeniu',
                  data: {
                     'id_elem_meniu':id_elem_meniu,
                     'id_parinte': id_parinte,
                     'vecin_urmator':vecin_urmator,
                     'vecin_anterior':vecin_anterior,
                  },
                  success: function(response){
                     $('#salvat'+id_elem_meniu).fadeIn('slow').animate({opacity: 1.0}, 1500).fadeOut('slow');
                     ui.item.attr('data-previndex',response);
                  }
               });
            }
         });
         
         
      });
   </script>
@endpush
