@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
	<a href='/admin/tipuri-proiecte/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga tip proiect</a>
@endif
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($tipuri_proiecte) > 0)
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
   				@foreach($tipuri_proiecte as $tip_proiect)
   					<tr id="proiect_tip{{$tip_proiect->id_tip_proiect}}">
                       <td class="wd-15p">{{$tip_proiect->id_tip_proiect}}</td>
   						<td class="wd-15p"><?=(isset($tip_proiect->parinteMostenit)?$tip_proiect->parinteMostenit->tip_proiect." > ":'')?>{{$tip_proiect->tip_proiect}}</td>
					   <td class="wd-20p"><?=(isset($tip_proiect->utilizator) ? $tip_proiect->utilizator->nume_utilizator." ".$tip_proiect->utilizator->prenume_utilizator:'')?></td>
   						<td class="wd-20p text-right">
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['edit']) && $drepturi[$pagina]['edit']))
								<a href='/admin/tipuri-proiecte/{{$tip_proiect->id_tip_proiect}}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
							@endif
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['delete']) && $drepturi[$pagina]['delete']))
								<form class='d-inline-block' method='POST' action="{{route('admin.tipuri-proiecte.destroy', $tip_proiect->id_tip_proiect)}}">
									@csrf
									<input type='hidden' name='_method' value='DELETE'>
									<button type="submit" class="btn btn-danger stergere"  data-tip='proiect_tip' data-nume='{{$tip_proiect->tip_proiect}}' data-id='{{$tip_proiect->id_tip_proiect}}'>
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
   		<p class="marginBottom40">Nici un tip de proiect.</p>
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
