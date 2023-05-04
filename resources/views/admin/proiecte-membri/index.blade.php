@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
	<a href='/admin/proiecte-membri/<?=$id_proiect?>/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga membru</a>
@endif
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($membri) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Nume si prenume</th>
   						<th class="wd-20p">Functie in cadrul proiectului</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($membri as $membru)
   					<tr id="proiect_membru{{$membru->id_proiect_membru}}">
   						<td class="wd-15p">{{$membru->id_proiect_membru}}</td>
   						<td class="wd-20p">{{$membru->cd->nume_cd}} {{$membru->cd->prenume_cd}}</td>
						<td class="wd-20p">{{$membru->functie_membru}}</td>
   						<td class="wd-20p text-right">
						   @if($utilizator->admin==1 || (isset($drepturi[$pagina]['edit']) && $drepturi[$pagina]['edit']))
   								<a href='/admin/proiecte-membri/{{$membru->id_proiect}}/{{$membru->id_proiect_membru}}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
							@endif
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['delete']) && $drepturi[$pagina]['delete']))
								<form class='d-inline-block' method='POST' action="{{route('admin.proiecte-membri.destroy', $membru->id_proiect_membru)}}">
									@csrf
									<input type='hidden' name='_method' value='DELETE'>
									<button type="submit" class="btn btn-danger stergere"  data-tip='proiect_membru' data-nume='{{$membru->cd->nume_cd}} {{$membru->cd->prenume_cd}}' data-id='{{$membru->id_proiect_membru}}'>
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
   		<p class="marginBottom40">Nici un membru.</p>
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
