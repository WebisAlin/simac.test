@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
	<a href='/admin/proiecte-notificari/<?=$id_proiect?>/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga notificare</a>
@endif
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($notificari_proiecte) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Text</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($notificari_proiecte as $notificare_proiect)
   					<tr id="proiect_notificare{{$notificare_proiect->id_proiect_notificare}}">
   						<td class="wd-15p">{{$notificare_proiect->id_proiect_notificare}}</td>
   						<td class="wd-20p"><?=$notificare_proiect->text_notificare_proiect?></td>
   						<td class="wd-20p text-right">
						   @if($utilizator->admin==1 || (isset($drepturi[$pagina]['edit']) && $drepturi[$pagina]['edit']))
   								<a href='/admin/proiecte-notificari/{{$notificare_proiect->id_proiect}}/{{$notificare_proiect->id_proiect_notificare}}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
							@endif
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['delete']) && $drepturi[$pagina]['delete']))
								<form class='d-inline-block' method='POST' action="{{route('admin.proiecte-notificari.destroy', $notificare_proiect->id_proiect_notificare)}}">
									@csrf
									<input type='hidden' name='_method' value='DELETE'>
									<button type="submit" class="btn btn-danger stergere"  data-tip='proiect_notificare' data-nume='{{strip_tags($notificare_proiect->text_notificare_proiect)}}' data-id='{{$notificare_proiect->id_proiect_notificare}}'>
										<i class='fa fa-minus-circle'></i>
									</button>
								</form>
							@endif
   						</td>
   					</tr>
   				@endforeach
   				</tbody>
   			</table>
   		</div>
   	@else
   		<p class="marginBottom40">Nici o notificare.</p>
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
			{ width: '25%' },
			{ width: '10%' },
		],
			"columnDefs": [
			{ "type": "num", "targets": 0 }
		],
		'order': [[ 0, 'desc' ]],
		'language': {
			'url': '/assets/datatable/ro_RO.json'
		},
		"pageLength": 10,
	});
});
</script>
@endpush