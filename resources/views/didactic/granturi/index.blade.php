@extends('layouts.didactic')
@section('content')
<a href='/cereri-granturi/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Creeaza cerere grant</a>
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($granturi) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Nume grant</th>
   						<th class="wd-20p">Telefon grant</th>
                        <th class="wd-20p">Email grant</th>
                        <th class="wd-20p">Data grant</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($granturi as $grant)
   					<tr id="grant-cerere{{$grant->id_grant_cerere}}">
   						<td class="wd-15p">{{$grant->id_grant_cerere}}</td>
   						<td class="wd-20p">{{$grant->nume_grant}} {{$grant->prenume_grant}}</td>
   						<td class="wd-20p">{{$grant->telefon_grant}}</td>
                        <td class="wd-20p">{{$grant->email_grant}}</td>
                        <td class="wd-20p">{{$grant->data_grant}}</td>
   						<td class="wd-20p text-right">
						   	<a href='/cereri-granturi/{{$grant->id_grant_cerere}}/pdf' class='btn btn-warning' target="_blank"><i class='fa fa-eye'></i></a>
							<button type="submit" class="btn btn-danger mr-2 remove p-2 stergereCerere" data-id='{{$grant->id_grant_cerere}}'><i class='fa fa-trash-alt'></i></button>
   						</td>
   					</tr>
   				@endforeach
   				</tbody>
   			</table>
   		</div>
   	@else
   		<p class="marginBottom40">Nu exista nici o cerere.</p>
   	@endif
   </div>
</div>
@endsection
@push('javascript')
<script>
$(function(e) {
	$('#datatable').DataTable({
		'columns': [
			{ width: '10%' },
			{ width: '20%' },
			{ width: '20%' },
			{ width: '20%' },
			{ width: '20%' },
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
