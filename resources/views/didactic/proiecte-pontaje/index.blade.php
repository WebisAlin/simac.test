@extends('layouts.didactic')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($pontaje) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-20p">Membru</th>
   						<th class="wd-20p">An-luna</th>
   						<th class="wd-20p">Total ore</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($pontaje as $pontaj)
   					<tr>
   						<td class="wd-15p">{{$pontaj->cd->nume_cd}} {{$pontaj->cd->prenume_cd}}</td>
   						<td class="wd-15p">{{$pontaj->an_luna_pontaj}}</td>
                        <td class="wd-15p">{{array_sum(unserialize($pontaj->ore_pontaj))}}</td>
   						<td class="wd-20p text-right">
						   <a href="/pontaje/show/{{$pontaj->id_proiect}}/{{$pontaj->id_cd}}" class="btn btn-sm btn-info" title="Vizualizare pontaj"><i class="fas fa-eye"></i></a>
   							<a href='#' class='btn btn-success btn-sm <?=($pontaj->status_pontaj?'disabled':'btnValideazaPontaj')?>' <?=($pontaj->status_pontaj?'':'disabled')?> title="<?=($pontaj->status_pontaj?'Pontaj validat':'Valideaza pontaj')?>" data-id="{{$pontaj->id_pontaj}}"><i class='fa fa-check'></i></a>
   						</td>
   					</tr>
   				@endforeach
   				</tbody>
   			</table>
   		</div>
   	@else
   		<p class="marginBottom40">Nici un pontaj inregistrat pentru acest proiect.</p>
   	@endif
   </div>
</div>

@endsection
@push('javascript')
<script>
$(function(e) {
	$('#datatable').DataTable({
		'columns': [
			{ width: '15%' },
			{ width: '15%' },
			{ width: '10%' },
			{ width: '10%' },
		],
			"columnDefs": [
			{ "type": "num", "targets": 0 }
		],
		'order': [[ 1, 'desc' ]],
		'language': {
			'url': '/assets/datatable/ro_RO.json'
		},
		"pageLength": 10,
	});
});
</script>
@endpush