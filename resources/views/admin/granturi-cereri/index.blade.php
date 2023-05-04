@extends('layouts.admin')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($granturi_cereri) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Nume cerere grant</th>
   						<th class="wd-20p">Telefon cerere grant</th>
                        <th class="wd-20p">Email cerere grant</th>
                        <th class="wd-20p">Data</th>
                        <th class="wd-20p">Status</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($granturi_cereri as $grant)
   					<tr id="grant-cerere{{$grant->id_grant_cerere}}">
   						<td class="wd-15p">{{$grant->id_grant_cerere}}</td>
   						<td class="wd-20p">{{$grant->nume_grant}} {{$grant->prenume_grant}}</td>
   						<td class="wd-20p">{{$grant->telefon_grant}}</td>
                        <td class="wd-10p">{{$grant->email_grant}}</td>
                        <td class="wd-20p">{{date("d-m-Y", strtotime($grant->data_grant))}}</td>
                        <td class="wd-30p">
                            @if($grant->status_grant == "initiat")
                                <button type="button" class="btn btn-secondary">Initiat</button>
                            @elseif($grant->status_grant == "validat")
                                <button type="button" class="btn btn-warning">Validat</button>
                            @elseif($grant->status_grant == "acceptat")
                                <button type="button" class="btn btn-success">Acceptat</button>
                            @else
                                <button type="button" class="btn btn-danger">Respins</button>
                            @endif
                        </td>
   						<td class="wd-20p text-right">
						   	<a href='/admin/granturi-cereri/{{$grant->id_grant_cerere}}/pdf' class='btn btn-info' target="_blank"><i class='fa fa-eye'></i></a>
                            <a href='/admin/granturi-cereri/{{$grant->id_grant_cerere}}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
							<button type="submit" class="btn btn-danger mr-2 remove p-2 stergereCerere" data-id='{{$grant->id_grant_cerere}}'><i class='fa fa-trash-alt'></i></button>
   						</td>
   					</tr>
   				@endforeach
   				</tbody>
   			</table>
   		</div>
   	@else
   		<p class="marginBottom40">Nu exista nici o cerere.</p>
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
			{ width: '23%' },
			{ width: '15%' },
			{ width: '10%' },
            { width: '10%' },
			{ width: '12%' },
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
