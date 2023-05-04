@extends('layouts.admin')
@section('content')
<a href='/admin/notificari/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Trimite notificare noua</a>

<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      @if(count($notificari) > 0)
      <div class="table-responsive">
         <table id="datatable" class="table table-striped table-bordered" style="width:100%">
            <thead>
               <tr>
                  <th style="width: 10%;">ID</th>
                  <th style="width: 15;">Titlu notificare</th>
                  <th style="width: 15;">Text notificare</th>
                  <th style="width: 15%;">DATA</th>
                  <th style="width: 15%;">Link-uri</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($notificari as $notificare)
                  <tr id='notificare{{$notificare->id_notificare}}'>
                     <td>{{ $notificare->id_notificare }}</td>
                     <td>{{ $notificare->titlu_notificare }}</td>
                     <td>{{ strip_tags($notificare->text_notificare) }}</td>
                     <td>{{ date('d-m-Y H:i:s', strtotime($notificare->created_at)) }}</td>
                     <td class="text-right">
                        <a href='/admin/notificari/{{$notificare->id_notificare}}/edit' class='btn btn-info'><i class='fa fa-eye'></i></a>
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>
      @else
      <p class="marginBottom40">Nicio notificare.</p>
      @endif
   </div>
</div>
@endsection
@push('javascript')
<script>
$(function(e) {
   $('#datatable').DataTable({
      'columns': [
         { width: '5%' },
         { width: '10%' },
         { width: '30%' },
         { width: '10%' },
         { width: '10%' },
      ],
      "columnDefs": [
         { "type": "num", "targets": 0 }
      ],
      'order': [[ 0, 'desc' ]],
      'language': {
         'url': '/assets/datatable/ro_RO.json'
      },
      
   });
});
</script>
@endpush
