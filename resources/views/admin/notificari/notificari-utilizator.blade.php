@extends('layouts.admin')
@section('content')

<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
        @if(count($notificariAll) > 0)
            @foreach ($notificariAll as $notificareUtilizator)
                <?php $notificare=$notificareUtilizator->notificare;?>
                <div id="notificare{{$notificareUtilizator->id_utilizator_notificare}}" class="row ticket-card  pt-2 border-bottom pb-2">
                    <div class="ticket-details col-md-10">
                        <div class="d-flex">
                            <p class="font-weight-semibold mb-0 ellipsis">{{$notificare->titlu_notificare}}</p>
                        </div>
                        <p class="text-gray mb-2"><?=$notificare->text_notificare?></p>
                        <div class="row text-gray d-md-flex d-none">
                            <div class="col-6 d-flex">
                                <small class="mb-0 mr-2 text-muted">Data trimiterii:</small>
                                <small class="mr-2 mb-0 text-muted font-weight-light">{{date('d-m-Y', strtotime($notificare->created_at))}}</small>
                            </div>
                        </div>
                    </div>
                    <div class="ticket-actions col-md-2 my-auto text-right">
                        @if($notificareUtilizator->citita)
                           <span data-id="{{$notificareUtilizator->id_utilizator_notificare}}" class="btn btn-sm disabled btn-info" disabled title="Citita"><i class="fas fa-check-double"></i></span>
                        @else
                           <span data-id="{{$notificareUtilizator->id_utilizator_notificare}}" class="btn btn-sm btn-info marcheazaCitita" title="Marcheaza citita"><i class="fas fa-check"></i></span>
                        @endif
                    </div>
                </div>
            @endforeach
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
      'order': [[ 0, 'desc' ]],
      'language': {
         url: '/assets/datatable/ro_RO.json'
      },
   });
});
</script>
@endpush
