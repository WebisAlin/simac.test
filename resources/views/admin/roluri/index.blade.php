@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
	<a href='/admin/roluri/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga rol</a>
@endif
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($roluri) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Rol</th>
   						<th class="wd-20p">Creat de</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($roluri as $rol)
   					<tr id="rol{{$rol->id_rol}}">
   						<td class="wd-15p">{{$rol->id_rol}}</td>
   						<td class="wd-20p">{{$rol->nume_rol}}</td>
						<td class="wd-20p"><?=(isset($rol->utilizator) ? $rol->utilizator->nume_utilizator." ".$rol->utilizator->prenume_utilizator:'')?></td>
   						<td class="wd-20p text-right">
						   @if($utilizator->admin==1 || (isset($drepturi[$pagina]['edit']) && $drepturi[$pagina]['edit']))
   								<a href='/admin/roluri/{{$rol->id_rol}}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
							@endif
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['delete']) && $drepturi[$pagina]['delete']))
								<form class='d-inline-block' method='POST' action="{{route('admin.roluri.destroy', $rol->id_rol)}}">
									@csrf
									<input type='hidden' name='_method' value='DELETE'>
									<button type="submit" class="btn btn-danger stergere"  data-tip='rol' data-nume='{{$rol->nume_rol}}' data-id='{{$rol->id_rol}}'>
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
   		<p class="marginBottom40">Nici un rol.</p>
   	@endif
   </div>
</div>

@endsection
@push('javascript')
<script>
$(function(e) {
	$('#datatable').DataTable({
		'columns': [
			{ width: '20%' },
			{ width: '20%' },
			{ width: '10%' },
			{ width: '20%' },
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
