@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
	<a href='/admin/facultati/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga facultate</a>
@endif
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($facultati) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Nume facultate</th>
   						<th class="wd-20p">Creat de</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($facultati as $facultate)
   					<tr id="facultate{{$facultate->id_facultate}}">
                       <td class="wd-15p">{{$facultate->id_facultate}}</td>
   						<td class="wd-15p">{{$facultate->nume_facultate}}</td>
  					  	<td class="wd-20p"><?=(isset($facultate->utilizator) ? $facultate->utilizator->nume_utilizator." ".$facultate->utilizator->prenume_utilizator:'')?></td>

   						<td class="wd-20p text-right">
						   	@if($utilizator->admin==1 || (isset($drepturi[$pagina]['edit']) && $drepturi[$pagina]['edit']))
   							<a href='/admin/facultati/{{$facultate->id_facultate}}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
   							@endif
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['delete']) && $drepturi[$pagina]['delete']))
								<form class='d-inline-block' method='POST' action="{{route('admin.facultati.destroy', $facultate->id_facultate)}}">
									@csrf
									<input type='hidden' name='_method' value='DELETE'>
									<button type="submit" class="btn btn-danger stergere"  data-tip='facultate' data-nume='{{$facultate->nume_facultate}}' data-id='{{$facultate->id_facultate}}'>
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
   		<p class="marginBottom40">Nu exista facultati.</p>
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
