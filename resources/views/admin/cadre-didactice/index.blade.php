@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
	<a href='/admin/cadre-didactice/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga cadru didactic</a>
@endif
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($cadreDidactice) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Nume cadru didactic</th>
   						<th class="wd-20p">Email cadru didactic</th>
						<th class="wd-20p">Telefon cadru didactic</th>
						<th class="wd-20p">Facultate</th>
						<th class="wd-20p">Departament</th>
						<th class="wd-20p">Creat de</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($cadreDidactice as $cadru)
   					<tr id="didactic{{$cadru->id_cd}}">
					   <td class="wd-20p">{{$cadru->id_cd}}</td>
   						<td class="wd-15p">{{$cadru->nume_cd}} {{$cadru->prenume_cd}}</td>
   						<td class="wd-20p">{{$cadru->email_cd}}</td>
             			<td class="wd-15p">{{$cadru->telefon_cd}}</td>
   						<td class="wd-20p">{{$cadru->facultate->nume_facultate}}</td>
   						<td class="wd-20p">{{$cadru->departament->nume_departament}}</td>
              			<td class="wd-20p"><?=(isset($cadru->utilizator) ? $cadru->utilizator->nume_utilizator." ".$cadru->utilizator->prenume_utilizator:'')?></td>
   						<td class="wd-20p text-right">
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['edit']) && $drepturi[$pagina]['edit']))
								<a href='/admin/cadre-didactice/{{$cadru->id_cd}}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
							@endif
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['delete']) && $drepturi[$pagina]['delete']))
								<form class='d-inline-block' method='POST' action="{{route('admin.cadre-didactice.destroy', $cadru->id_cd)}}">
									@csrf
									<input type='hidden' name='_method' value='DELETE'>
									<button type="submit" class="btn btn-danger stergere"  data-tip='didactic' data-nume='{{$cadru->nume_cd}}' data-id='{{$cadru->id_cd}}'>
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
   		<p class="marginBottom40">Nici un cadru didactic.</p>
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
			{ width: '15%' },
			{ width: '15%' },
      { width: '15%' },
			{ width: '10%' },
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
