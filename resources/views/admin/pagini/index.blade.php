@extends('layouts.admin')
@section('content')
@if($utilizator->admin==1 || (isset($drepturi[$pagina]['add']) && $drepturi[$pagina]['add']))
    <a href='/admin/pagini/create' class='btn btn-primary float-right mb-5'><i class='fa fa-plus'></i> Adauga pagina</a>
@endif
<div class="card overflow-hidden">
    @if(isset($pagini))
        <div class="card overflow-hidden">
            <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
            <div class="card-body ">
                @if(count($pagini) > 0)
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Titlu </th>
                                    <th>SLUG</th>
                                    <th class="wd-20p">Creat de</th>
                                    <th class="wd-20p">Link-uri</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pagini as $paginaActual)
                                    <tr id="pagina{{ $paginaActual->id_pagina }}">
                                        <td class="wd-15p">{{ $paginaActual->id_pagina }}</td>
                                        <td>{{ $paginaActual->nume_pagina }}</td>
                                        <td>{{ $paginaActual->slug_pagina }}</td>
                                        <td class="wd-20p"><?=(isset($paginaActual->utilizator) ? $paginaActual->utilizator->nume_utilizator." ".$paginaActual->utilizator->prenume_utilizator:'')?></td>
                                        <td class="wd-20p text-right">
                                            @if($utilizator->admin==1 || (isset($drepturi[$pagina]['edit']) && $drepturi[$pagina]['edit']))
                                                <a href='/admin/pagini/{{ $paginaActual->id_pagina }}/edit' class='btn btn-warning mr-2 p-2'><i class='fa fa-edit'></i></a>
                                            @endif
                                            @if($utilizator->admin==1 || (isset($drepturi[$pagina]['delete']) && $drepturi[$pagina]['delete']))
                                                <form class='d-inline-block' method='POST'
                                                    action="{{ route('admin.pagini.destroy', $paginaActual->id_pagina) }}">
                                                    @csrf
                                                    <input type='hidden' name='_method' value='DELETE'>
                                                    <button type="submit"
                                                        class="btn btn-danger mr-2 remove p-2 stergere"
                                                        data-tip='pagina' data-nume='{{ $paginaActual->nume_pagina }}'
                                                        data-id='{{ $paginaActual->id_pagina }}'>
                                                        <i class='fa fa-trash-alt'></i>
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
                    <p class="marginBottom40">Nu exista pagini.</p>
                @endif
                
            </div>
        </div>
    
    @endif
</div>

@push('javascript')
    <script>
        $(function (e) {
            $('#datatable').DataTable({
                "columns": [{
                        "width": "10%"
                    },
                    {
                        "width": "35%"
                    },
                    {
                        "width": "20%"
                    },
                    {
                        "width": "15%"
                    },
                    {
                        "width": "20%"
                    },
                ],
                'order': [
                    [0, 'desc']
                ],
                'language': {
                    'url': '/assets/datatable/ro_RO.json'
                },
            });
        });

    </script>
@endpush
@endsection
