@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
	<a href='/admin/granturi-clasificari/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga clasificare grant</a>
@endif
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($granturi_clasificari) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Nume clasificare grant</th>
   						<th class="wd-20p">Valoare grant cu autori straini</th>
   						<th class="wd-20p">Valoare grant fara autori straini</th>
   						<th class="wd-20p">Creat de</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($granturi_clasificari as $grant_clasificare)
   					<tr id="grant_clasificare{{$grant_clasificare->id_grant_clasificare }}">
                       <td class="wd-15p">{{$grant_clasificare->id_grant_clasificare }}</td>
   						<td class="wd-15p">{{$grant_clasificare->nume_grant_clasificare}}</td>
   						<td class="wd-15p">{{$grant_clasificare->valoare_straini_da}}</td>
   						<td class="wd-15p">{{$grant_clasificare->valoare_straini_nu}}</td>
						<td class="wd-20p"><?=(isset($grant_clasificare->utilizator) ? $grant_clasificare->utilizator->nume_utilizator." ".$grant_clasificare->utilizator->prenume_utilizator:'')?></td>
   						<td class="wd-20p text-right">
						    @if($utilizator->admin==1 || (isset($drepturi[$pagina]['edit']) && $drepturi[$pagina]['edit']))
   								<a href='/admin/granturi-clasificari/{{$grant_clasificare->id_grant_clasificare }}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
							@endif
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['delete']) && $drepturi[$pagina]['delete']))
								<form class='d-inline-block' method='POST' action="{{route('admin.granturi-clasificari.destroy', $grant_clasificare->id_grant_clasificare )}}">
									@csrf
									<input type='hidden' name='_method' value='DELETE'>
									<button type="submit" class="btn btn-danger stergere"  data-tip='grant_clasificare' data-nume='{{$grant_clasificare->nume_grant_clasificare}}' data-id='{{$grant_clasificare->id_grant_clasificare }}'>
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
   		<p class="marginBottom40">Nici o clasificare.</p>
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
			{ width: '15%' },
			{ width: '15%' },
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
