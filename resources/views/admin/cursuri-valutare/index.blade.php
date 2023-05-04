@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
    <a href='/admin/cursuri-valutare/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga curs valutar</a>
@endif
<div class="card">
    <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
    <div class="card-body">
        @if(count($cursuriValutare) > 0)
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="wd-15p">#</th>
                            <th class="wd-20p">Luna curs valutar</th>
                            <th class="wd-20p">An</th>
                            <th class="wd-20p">Valuta</th>
                            <th class="wd-20p">Valoare</th>
                            <th class="wd-20p">Link-uri</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cursuriValutare as $cursValutar)
                            <tr id="valutar{{ $cursValutar->id_curs }}">
                                <td class="wd-15p">{{ $cursValutar->id_curs }}</td>
                                @if($cursValutar->luna_an_curs_valutar == 1)
                                <td class="wd-15p">Ianuarie</td>
                                @elseif($cursValutar->luna_an_curs_valutar == 2)
                                <td class="wd-15p">Februarie</td>
                                @elseif($cursValutar->luna_an_curs_valutar == 3)
                                <td class="wd-15p">Martie</td>
                                @elseif($cursValutar->luna_an_curs_valutar == 4)
                                <td class="wd-15p">Aprilie</td>
                                @elseif($cursValutar->luna_an_curs_valutar == 5)
                                <td class="wd-15p">Mai</td>
                                @elseif($cursValutar->luna_an_curs_valutar == 6)
                                <td class="wd-15p">Iunie</td>
                                @elseif($cursValutar->luna_an_curs_valutar == 7)
                                <td class="wd-15p">Iulie</td>
                                @elseif($cursValutar->luna_an_curs_valutar == 8)
                                <td class="wd-15p">August</td>
                                @elseif($cursValutar->luna_an_curs_valutar == 9)
                                <td class="wd-15p">Septembrie</td>
                                @elseif($cursValutar->luna_an_curs_valutar == 10)
                                <td class="wd-15p">Octombrie</td>
                                @elseif($cursValutar->luna_an_curs_valutar == 11)
                                <td class="wd-15p">Noiembrie</td>
                                @elseif($cursValutar->luna_an_curs_valutar == 12)
                                <td class="wd-15p">Decembrie</td>
                                @endif
                                <td class="wd-15p">{{ strtoupper($cursValutar->an_curs_valutar) }}</td>
                                <td class="wd-15p">{{ strtoupper($cursValutar->valuta) }}</td>
                                <td class="wd-15p">{{ $cursValutar->valoare_curs_valutar }}</td>
                                <td class="wd-20p text-right">
                                        @if($utilizator->admin==1 || (isset($drepturi[$pagina]['edit']) && $drepturi[$pagina]['edit']))
                                        <a href='/admin/cursuri-valutare/{{ $cursValutar->id_curs }}/edit' class='btn btn-warning'><i class='fa fa-edit'></i></a>
                                        @endif
                                        @if($utilizator->admin==1 || (isset($drepturi[$pagina]['delete']) && $drepturi[$pagina]['delete']))
                                            <form class='d-inline-block' method='POST'
                                                action="{{ route('admin.cursuri-valutare.destroy', $cursValutar->id_curs) }}">
                                                @csrf
                                                <input type='hidden' name='_method' value='DELETE'>
                                                <button type="submit" class="btn btn-danger stergere" data-tip='valutar'
                                                    data-nume='{{ $cursValutar->id_curs }}'
                                                    data-id='{{ $cursValutar->id_curs }}'>
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
            <p class="marginBottom40">Nu exista cursuri valutare.</p>
        @endif
    </div>
</div>

@endsection
@push('javascript')
    <script>
        $(function (e) {
            $('#datatable').DataTable({
                'columns': [{
                        width: '5%'
                    },
                    {
                        width: '45%'
                    },
                    {
                        width: '10%'
                    },
                    {
                        width: '10%'
                    },
                    {
                        width: '10%'
                    },
                    {
                        width: '10%'
                    },
                ],
                "columnDefs": [{
                    "type": "num",
                    "targets": 0
                }],
                'order': [
                    [0, 'desc']
                ],
                'language': {
                    'url': '/assets/datatable/ro_RO.json'
                },
                "pageLength": 10,
            });
        });
    </script>
@endpush
