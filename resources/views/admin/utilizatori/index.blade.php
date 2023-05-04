@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
	<a href='/admin/utilizatori/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga utilizator</a>
@endif
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($utilizatori) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Avatar</th>
   						<th class="wd-20p">Nume</th>
   						<th class="wd-20p">Prenume</th>
   						<th class="wd-20p">Email</th>
   						<th class="wd-20p">Rol</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($utilizatori as $utilizatorActual)
   					<tr id="utilizator{{$utilizatorActual->id_utilizator}}">
					   <td class="wd-15p">{{$utilizatorActual->id_utilizator}}</td>
   						<td class="wd-15p">
						   <span class="avatar avatar-md brround" style="background-image: url(<?=($utilizatorActual->avatar?'/uploads/img_utilizatori/small/'.$utilizatorActual->avatar:'/imagini/no-avatar.png')?>)"></span>
						</td>
   						<td class="wd-20p">{{$utilizatorActual->nume_utilizator}}</td>
   						<td class="wd-20p">{{$utilizatorActual->prenume_utilizator}}</td>
   						<td class="wd-20p">{{$utilizatorActual->email_utilizator}}</td>
   						<td class="wd-20p">{{($utilizatorActual->rol->nume_rol ?? 'admin')}}</td>
   						<td class="wd-20p text-right">
						   @if($utilizator->admin==1 || (isset($drepturi[$pagina]['edit']) && $drepturi[$pagina]['edit']))
								<a href='/admin/utilizatori/{{$utilizatorActual->id_utilizator}}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
							@endif
							@if($utilizator->admin==1 || (isset($drepturi[$pagina]['delete']) && $drepturi[$pagina]['delete']))
								@if(!$utilizatorActual->admin)
									<form class='d-inline-block' method='POST' action="{{route('admin.utilizatori.destroy', $utilizatorActual->id_utilizator)}}">
										@csrf
										<input type='hidden' name='_method' value='DELETE'>
										<button type="submit" class="btn btn-danger stergere"  data-tip='utilizator' data-nume='{{$utilizatorActual->nume_utilizator}}' data-id='{{$utilizatorActual->id_utilizator}}'>
											<i class='fa fa-minus-circle'></i>
										</button>
									</form>
								@endif
							@endif
   						</td>
   					</tr>
   				@endforeach
   				</tbody>
   			</table>
   		</div>
   	@else
   		<p class="marginBottom40">Nici un utilizator.</p>
   	@endif
   </div>
</div>

@endsection
@push('javascript')
<script>
$(function(e) {
	$('#datatable').DataTable({
		'columns': [
			{ width: '10%' },
			{ width: '10%' },
			{ width: '20%' },
			{ width: '20%' },
			{ width: '20%' },
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
