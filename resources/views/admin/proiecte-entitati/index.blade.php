@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
	<a href='/admin/proiecte-entitati/<?=$id_proiect?>/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga entitate</a>
@endif
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($entitati) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Entitate</th>
   						<th class="wd-20p">Rol</th>
   						<th class="wd-20p">Procent alocat (%)</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($entitati as $entitate)
   					<tr id="proiect_entitate{{$entitate->id_proiect_entitate}}">
   						<td class="wd-15p">{{$entitate->id_proiect_entitate}}</td>
                        <td class="wd-20p">{{$entitate->universitate->nume_universitate}}</td>
   						<td class="wd-20p">{{$entitate->rol_entitate}}</td>
   						<td class="wd-20p">{{$entitate->procent_alocat_entitate}}</td>
   						<td class="wd-20p text-right">
						   @if($utilizator->admin==1 || (isset($drepturi[$pagina]['edit']) && $drepturi[$pagina]['edit']))
   								<a href='/admin/proiecte-entitati/{{$entitate->id_proiect}}/{{$entitate->id_proiect_entitate}}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
							@endif
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['delete']) && $drepturi[$pagina]['delete']))
								<form class='d-inline-block' method='POST' action="{{route('admin.proiecte-entitati.destroy', $entitate->id_proiect_entitate)}}">
									@csrf
									<input type='hidden' name='_method' value='DELETE'>
									<button type="submit" class="btn btn-danger stergere"  data-tip='proiect_entitate' data-nume='{{$entitate->universitate->nume_universitate}}' data-id='{{$entitate->id_proiect_entitate}}'>
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
   		<p class="marginBottom40">Nici o entitate.</p>
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
			{ width: '20%' },
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
		"pageLength": 10,
	});
});
</script>
@endpush