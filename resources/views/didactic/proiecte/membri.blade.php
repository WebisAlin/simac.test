@extends('layouts.didactic')
@section('content')
<div class="card">
   <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
   <div class="card-body">
   	@if(count($membri) > 0)
   		<div class="table-responsive">
   			<table id="datatable" class="table table-striped table-bordered" style="width:100%">
   				<thead>
   					<tr>
   						<th class="wd-15p">#</th>
   						<th class="wd-20p">Membru</th>
   						<th class="wd-20p">Functie in cadrul proiectului</th>
                        <th class="wd-20p">Atasamente</th>
   					</tr>
   				</thead>
   				<tbody>
   				@foreach($membri as $membru)
   					<tr id="proiect_membru{{$membru->id_proiect_membru}}">
   						<td class="wd-15p">{{$membru->id_proiect_membru}}</td>
                        <td class="wd-20p">{{$membru->cd->nume_cd}} {{$membru->cd->prenume_cd}}</td>
   						<td class="wd-20p">{{$membru->functie_membru}}</td>
                        <td class="wd-20p">
                            <div class="atasamente">
                                @foreach($membru->atasamente as $atasament)
                                    <a href="/uploads/atasamente_membri/{{$atasament->atasament}}" target="_blank">{{$atasament->atasament}}</a><br>
                                @endforeach
                            </div>
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
