@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
	<a href='/admin/granturi/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga grant</a>
@endif
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($granturi) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
						<th class="wd-20p">Numar grant</th>
   						<th class="wd-20p">Titlu grant</th>
   						<th class="wd-20p">Valoare UTCN</th>
   						<th class="wd-20p">Valoare cota parte</th>
   						<th class="wd-20p">Creat de</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($granturi as $grant)
   					<tr id="grant{{$grant->id_grant }}">
                       <td class="wd-15p">{{$grant->id_grant }}</td>
					   <td class="wd-15p">{{$grant->nr_grant}}</td>
   						<td class="wd-15p">{{$grant->titlu_grant}}</td>
   						<td class="wd-15p">{{$grant->valoare_utcn}}</td>
   						<td class="wd-15p">{{$grant->valoare_cota_parte}}</td>
						<td class="wd-20p"><?=(isset($grant->utilizator) ? $grant->utilizator->nume_utilizator." ".$grant->utilizator->prenume_utilizator:'')?></td>
   						<td class="wd-20p text-right">
						    @if($utilizator->admin==1 || (isset($drepturi[$pagina]['edit']) && $drepturi[$pagina]['edit']))
   								<a href='/admin/granturi-mutari/{{$grant->id_grant }}' class='btn btn-info'><i class="fas fa-exchange-alt"></i></a>
   								<a href='/admin/granturi/{{$grant->id_grant }}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
							@endif
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['delete']) && $drepturi[$pagina]['delete']))
								<form class='d-inline-block' method='POST' action="{{route('admin.granturi.destroy', $grant->id_grant )}}">
									@csrf
									<input type='hidden' name='_method' value='DELETE'>
									<button type="submit" class="btn btn-danger stergere" data-tip='grant' data-nume='{{$grant->titlu_grant}}' data-id='{{$grant->id_grant }}'>
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
			{ width: '5%' },
			{ width: '7%' },
			{ width: '35%' },
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
