@extends('layouts.didactic')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($granturi_autori) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">Nume grant</th>
   						<th class="wd-20p">Data expirare</th>
   						<th class="wd-20p">Valoare grant (lei)</th>
   						<th class="wd-20p">Valoare ramasa (lei)</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($granturi_autori as $grant_autor)
   					<tr>
   						<td class="wd-15p">{{$grant_autor->grant->titlu_grant}}</td>
   						<td class="wd-15p">{{date('d-m-Y', strtotime($grant_autor->grant->data_expirare_grant))}}</td>
   						<td class="wd-15p">{{$grant_autor->valoare_cota_parte_autor}}</td>
   						<td class="wd-15p">{{$grant_autor->valoare_ramasa_autor}}</td>
   						<td class="wd-20p text-right">
                           <a href="/granturi/{{$grant_autor->id_grant}}" class="btn btn-sm btn-pink" title="Vizualizeaza grant"><i class="fas fa-info-circle"></i></a>
                        </td>
   					</tr>
   				@endforeach
   				</tbody>
   			</table>
   		</div>
   	@else
   		<p class="marginBottom40">Nici un grant.</p>
   	@endif
   </div>
</div>
@endsection
@push('javascript')
<script>
$(function(e) {
	$('#datatable').DataTable({
		'columns': [
			{ width: '45%' },
			{ width: '15%' },
			{ width: '15%' },
			{ width: '15%' },
			{ width: '15%' },
		],
			"columnDefs": [
			{ "type": "num", "targets": 0 }
		],
		'order': [[ 1, 'asc' ]],
		'language': {
			'url': '/assets/datatable/ro_RO.json'
		},
		"pageLength": 10,
	});
});
</script>
@endpush

