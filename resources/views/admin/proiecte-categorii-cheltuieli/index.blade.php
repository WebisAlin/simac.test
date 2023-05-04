@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
	<a href='/admin/categorii-cheltuieli/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga categorie cheltuieli</a>
@endif
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($categorii_cheltuieli) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Tip proiect</th>
   						<th class="wd-20p">Creat de</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($categorii_cheltuieli as $categorie_cheltuiala)
   					<tr id="proiect_categorie_cheltuieli{{$categorie_cheltuiala->id_proiect_categorie_cheltuieli}}">
                       <td class="wd-15p">{{$categorie_cheltuiala->id_proiect_categorie_cheltuieli}}</td>
   						<td class="wd-15p"><?=(isset($categorie_cheltuiala->parinteMostenit)?$categorie_cheltuiala->parinteMostenit->nume_categorie_cheltuieli." > ":'')?>{{$categorie_cheltuiala->nume_categorie_cheltuieli}}</td>
					   <td class="wd-20p"><?=(isset($categorie_cheltuiala->utilizator) ? $categorie_cheltuiala->utilizator->nume_utilizator." ".$categorie_cheltuiala->utilizator->prenume_utilizator:'')?></td>
   						<td class="wd-20p text-right">
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['edit']) && $drepturi[$pagina]['edit']))
								<a href='/admin/categorii-cheltuieli/{{$categorie_cheltuiala->id_proiect_categorie_cheltuieli}}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
							@endif
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['delete']) && $drepturi[$pagina]['delete']))
								<form class='d-inline-block' method='POST' action="{{route('admin.categorii-cheltuieli.destroy', $categorie_cheltuiala->id_proiect_categorie_cheltuieli)}}">
									@csrf
									<input type='hidden' name='_method' value='DELETE'>
									<button type="submit" class="btn btn-danger stergere"  data-tip='proiect_categorie_cheltuieli' data-nume='{{$categorie_cheltuiala->nume_categorie_cheltuieli}}' data-id='{{$categorie_cheltuiala->id_proiect_categorie_cheltuieli}}'>
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
   		<p class="marginBottom40">Nici o categorie de cheltuieli.</p>
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
		'order': [[ 1, 'asc' ]],
		'language': {
			'url': '/assets/datatable/ro_RO.json'
		},
		"pageLength": 10,
	});
});
</script>
@endpush
