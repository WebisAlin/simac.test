@extends('layouts.admin')

@section('content')
<a href='/admin/limbi/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga limba</a>
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($limbi) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Acronim</th>
   						<th class="wd-20p">Limba</th>
   						<th class="wd-20p">Link-uri</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($limbi as $limba)
   					<tr id="limba{{$limba->id_limba}}">
   						<td class="wd-15p">{{$limba->id_limba}}</td>
   						<td class="wd-20p">{{$limba->limba}}</td>
   						<td class="wd-20p">{{$limba->nume_limba}}</td>
   						<td class="wd-20p text-right">
   							<a href='/admin/limbi/{{$limba->id_limba}}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
   							<form class='d-inline-block' method='POST' action="{{route('admin.limbi.destroy', $limba->id_limba)}}">
   								@csrf
   								<input type='hidden' name='_method' value='DELETE'>
   								<button type="submit" class="btn btn-danger stergere"  data-tip='limba' data-nume='{{$limba->nume_limba}}' data-id='{{$limba->id_limba}}'>
   									<i class='fa fa-minus-circle'></i>
   								</button>
   							</form>
   						</td>
   					</tr>
   				@endforeach
   				</tbody>
   			</table>
   		</div>
   	@else
   		<p class="marginBottom40">Nici o limba.</p>
   	@endif
   </div>
</div>

@endsection
@push('javascript')
<script>
$(function(e) {
	$('#datatable').DataTable({
		'columns': [
			{ width: '20%' },
			{ width: '30%' },
			{ width: '30%' },
			{ width: '20%' },
		],
			"columnDefs": [
			{ "type": "num", "targets": 0 }
		],
		'order': [[ 0, 'desc' ]],
		'language': {
			'url': '/assets/datatable/ro_RO.json'
		},
		'dom': 'Bfrtip',
		"pageLength": 10,
		'buttons': [
			{
				extend: 'csv',
				text: 'Export log',
			}
		],
	});
});
</script>
@endpush
