@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
	<a href='/admin/departamente/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga departament</a>
@endif
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($departamente) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Nume departament</th>
   						<th class="wd-20p">Creat de</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($departamente as $departament)
   					<tr id="departament{{$departament->id_departament}}">
                       <td class="wd-15p">{{$departament->id_departament}}</td>
   						<td class="wd-15p">{{$departament->nume_departament}}</td>
					   <td class="wd-20p"><?=(isset($departament->utilizator) ? $departament->utilizator->nume_utilizator." ".$departament->utilizator->prenume_utilizator:'')?></td>
   						<td class="wd-20p text-right">
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['edit']) && $drepturi[$pagina]['edit']))
								<a href='/admin/departamente/{{$departament->id_departament}}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
							@endif
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['delete']) && $drepturi[$pagina]['delete']))
								<form class='d-inline-block' method='POST' action="{{route('admin.departamente.destroy', $departament->id_departament)}}">
									@csrf
									<input type='hidden' name='_method' value='DELETE'>
									<button type="submit" class="btn btn-danger stergere"  data-tip='departament' data-nume='{{$departament->nume_departament}}' data-id='{{$departament->id_departament}}'>
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
   		<p class="marginBottom40">Nici un departament.</p>
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
			{ width: '70%' },
			{ width: '15%' },
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
