@extends('layouts.didactic')
@section('content')
<form action="{{ route('didactic.cereri-granturi.anexaStore') }}" method="post"enctype="multipart/form-data">
@csrf
@if($sesiuni['nr_anexa1']=="on")
    @include('didactic.granturi.anexa1')
@endif

@if($sesiuni['nr_anexa2']=="on")
    @include('didactic.granturi.anexa2')
@endif

@if($sesiuni['nr_anexa3']=="on")
    @include('didactic.granturi.anexa3')
@endif

@if($sesiuni['nr_anexa4']=="on")
    @include('didactic.granturi.anexa4')
@endif

@if($sesiuni['nr_anexa5']=="on")
    @include('didactic.granturi.anexa5')
@endif

@if($sesiuni['nr_anexa6']=="on")
    @include('didactic.granturi.anexa6')
@endif

<div class="row p-5">
    <div class="col-lg-12 text-right">
        <button type="submit" class="btn btn-primary pr-4">Creeaza</button>
    </div>
</div>
</form>
@endsection