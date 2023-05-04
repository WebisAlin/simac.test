@extends('layouts.didactic')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($proiecte) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">Cod proiect</th>
   						<th class="wd-20p">Denumire proiect</th>
   						<th class="wd-20p">Functie</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($proiecte as $id_proiect=>$proiect)
   					<tr>
                       <td class="wd-15p">{{$proiect['cod_proiect']}}</td>
   						<td class="wd-15p">{{$proiect['denumire_proiect']}}</td>
   						<td class="wd-15p">{{$proiect['functie']}}</td>
   						<td class="wd-20p text-right">
                           <a href="/proiect/{{$id_proiect}}" class="btn btn-sm btn-pink" title="Vizualizeaza proiect"><i class="fas fa-info-circle"></i></a>
                            @if($proiect['director'])
                                <a href="/proiect/{{$id_proiect}}/membri" class="btn btn-sm btn-info" title="Membri proiect"><i class="fas fa-users"></i></a>
                                <a href="/pontaje/list/{{$id_proiect}}" class="btn btn-sm btn-primary" title="Valideaza pontaje"><i class="fas fa-calendar-alt"></i></a>
                            @endif
                            <a href="/pontaje/edit/{{$id_proiect}}/{{$cd->id_cd}}" class="btn btn-sm btn-success" title="Adauga pontaj"><i class="fas fa-calendar-plus"></i></a>
   						</td>
   					</tr>
   				@endforeach
   				</tbody>
   			</table>
   		</div>
   	@else
   		<p class="marginBottom40">Nici un proiect.</p>
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
			{ width: '65%' },
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

