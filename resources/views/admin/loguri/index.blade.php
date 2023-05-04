@extends('layouts.admin')
@section('content')

<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
      <form class="row mb-2">
         <div class="col-sm-6 text-right">
            @if($start || $stop)
            <label style="height:46px"></label>
               <a class="btn btn-secondary d-inline-block" href="/admin/loguri"><i class="fas fa-redo"></i></a>
            @endif
         </div>
         <div class="col-sm-2">
            <label>De la</label>
            <input class="form-control datepicker" value="<?=(isset($start)?date('d-m-Y', strtotime($start)):'')?>" type="text" name="start" />
         </div>
         <div class="col-sm-2">
            <label>Până la</label>
            <input class="form-control datepicker" value="<?=(isset($stop)?date('d-m-Y', strtotime($stop)):'')?>" type="text" name="stop" />
         </div>
         <div class="col-sm-2 text-right my-auto">
            <label style="height:40px"></label>
            <input type="submit" class="btn btn-info" value="Filtrează"/>
         </div>
      </form>
      @if(count($loguri) > 0)
      <div class="table-responsive">
         <table id="datatable" class="table table-striped table-bordered" style="width:100%">
            <thead>
               <tr>
                  <th style="width: 10%;">ID</th>
                  <th style="width: 10%;">Tip utilizator</th>
                  <th style="width: 10%;">Nume</th>
                  <th style="width: 15;">TIP MODIFICARE</th>
                  <th style="width: 35%;">TEXT</th>
                  <th style="width: 15%;">DATA</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($loguri as $log)
               <tr id='log{{$log->id_log}}'>
                  <td>{{ $log->id_log }}</td>
                  <td>{{ $log->tip_user }}</td>
                  <td>{{ $log->getRealUser()->name }}</td>
                  <td>{{ $log->tip_log }}</td>
                  <td>{{ $log->text_log }}</td>
                  <td>{{ date('d-m-Y H:i:s', strtotime($log->created_at)) }}</td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
      @else
      <p class="marginBottom40">Niciun log.</p>
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
         { width: '10%' },
         { width: '10%' },
         { width: '30%' },
         { width: '10%' },
      ],
      "columnDefs": [
         { "type": "num", "targets": 0 }
      ],
      'order': [[ 0, 'desc' ]],
      'language': {
         'url': '/assets/datatable/ro_RO.json'
      },
      initComplete: function () {
         this.api()
         .columns()
         .every(function (i) {
            var column = this;
            if(i==3){ // coloana tip
               var select = $('<select class="form-control"><option value="">Alege tip modificare</option></select>')
               .appendTo($(column.header()).empty())
               .on('change', function () {
                  var val = $.fn.dataTable.util.escapeRegex($(this).val());
                  column.search(val ? '^' + val + '$' : '', true, false).draw();
               });
               column
               .data()
               .unique()
               .sort()
               .each(function (d, j) {
                  select.append('<option value="' + d + '">' + d + '</option>');
               });
            }
         });
      },
   });
});
</script>
@endpush
