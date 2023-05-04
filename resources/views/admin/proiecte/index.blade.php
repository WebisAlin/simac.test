@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
	<a href='/admin/proiecte/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga proiect</a>
@endif
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($proiecte) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Denumire</th>
   						<th class="wd-20p">Director proiect</th>
   						<th class="wd-20p">Valoare proiect</th>
   						<th class="wd-20p">Data inceput</th>
   						<th class="wd-20p">Data final</th>
   						<th class="wd-20p">Creat de</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($proiecte as $proiect)
   					<tr id="proiect{{$proiect->id_proiect}}">
   						<td class="wd-15p">{{$proiect->id_proiect}}</td>
						   <td class="wd-20p">{{$proiect->denumire_proiect}}</td>
   						<td class="wd-20p">{{$proiect->director->nume_cd}} {{$proiect->director->prenume_cd}}</td>
   						<td class="wd-20p">{{$proiect->valoare_proiect}}</td>
   						<td class="wd-20p">{{date('d-m-Y', strtotime($proiect->data_inceput_proiect))}}</td>
   						<td class="wd-20p">{{date('d-m-Y', strtotime($proiect->data_final_proiect))}}</td>
						<td class="wd-20p"><?=(isset($proiect->utilizator) ? $proiect->utilizator->nume_utilizator." ".$proiect->utilizator->prenume_utilizator:'')?></td>
   						<td class="wd-20p text-right">
						   @if($utilizator->admin==1 || (isset($drepturi[$pagina]['edit']) && $drepturi[$pagina]['edit']))
   								<a href='/admin/proiecte-entitati/{{$proiect->id_proiect}}' class='btn btn-purple' title="Entitati proiect" ><i class='fa fa-university'></i></a>
   								<a href='/admin/proiecte-membri/{{$proiect->id_proiect}}' class='btn btn-info' title="Membri proiect" ><i class='fa fa-users'></i></a>
   								<a href='/admin/proiecte-notificari/{{$proiect->id_proiect}}' class='btn btn-pink' title="Notificari proiect" ><i class='fa fa-info-circle'></i></a>
   								<a href='/admin/proiecte/{{$proiect->id_proiect}}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
							@endif
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['delete']) && $drepturi[$pagina]['delete']))
								<form class='d-inline-block' method='POST' action="{{route('admin.proiecte.destroy', $proiect->id_proiect)}}">
									@csrf
									<input type='hidden' name='_method' value='DELETE'>
									<button type="submit" class="btn btn-danger stergere"  data-tip='proiect' data-nume='{{$proiect->denumire_proiect}}' data-id='{{$proiect->id_proiect}}'>
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
			{ width: '15%' },
			{ width: '15%' },
			{ width: '10%' },
			{ width: '10%' },
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
