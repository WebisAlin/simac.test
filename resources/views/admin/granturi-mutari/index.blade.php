@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
	<a href='/admin/granturi-mutari/<?=$id_grant?>/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga mutare valoare</a>
@endif
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($mutari) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Cadru didactic sursa</th>
   						<th class="wd-20p">Cadru didactic destinatie</th>
   						<th class="wd-20p">Valoare  (lei)</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($mutari as $mutare)
   					<tr id="grant_mutare{{$mutare->id_grant_mutare_valoare}}">
   						<td class="wd-15p">{{$mutare->id_grant_mutare_valoare}}</td>
                        <td class="wd-20p">{{$mutare->cd_sursa->nume_cd}} {{$mutare->cd_sursa->prenume_cd}}</td>
   						<td class="wd-20p">{{$mutare->cd_destinatie->nume_cd}} {{$mutare->cd_destinatie->prenume_cd}}</td>
   						<td class="wd-20p">{{$mutare->valoare_mutata}}</td>
   					</tr>
   				@endforeach
   				</tbody>
   			</table>
   		</div>
   	@else
   		<p class="marginBottom40">Nici o mutare.</p>
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