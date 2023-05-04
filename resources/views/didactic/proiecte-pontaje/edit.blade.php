@extends('layouts.didactic')
@section('content')
<form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
    <div class="card">
        <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-2">
                    <select class="form-control" name="luna">
                        @foreach($arrayLuni as $index=>$luna_primita)
                            <option value="{{$index}}" <?=($index==$luna?'selected':'')?>>{{$luna_primita}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <select class="form-control" name="an">
                        @for($an_primit=(date('Y')-1);$an_primit<=(date('Y')+1);$an_primit++)
                            <option value="{{$an_primit}}" <?=($an==$an_primit?'selected':'')?>>{{$an_primit}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-sm-2 my-auto">
                    <input name="actiune" type="hidden" value="edit">
                    <span class="btn btn-sm btn-primary perioadaPontaje">Cauta</span>
                </div>
                <div class="col-sm-6 my-auto text-right">
                    <span class="btn btn-{{($status_pontaj?'success':'secondary')}} disabled">{{($status_pontaj?'validat':'nevalidat')}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
        <div class="card-body">
            @csrf
            <?php if($action=="modifica"){
                echo "<input type='hidden' name='_method' value='PUT'>
                <input type='hidden' name='id_proiect' value='".$id_proiect."' />
                <input type='hidden' name='id_cd' value='".$id_cd."' />
                <input name='id_pontaj' type='hidden' value='".$id_pontaj."'>";
            }?>
                
            <div class="zile_pontaj" style="grid-template-columns:repeat(<?=$nr_zile_luna+1?>,1fr)">
                <div class="zi_pontaj">Zi</div>
                @for($zi=1;$zi<=$nr_zile_luna; $zi++)
                    <?php if(strlen($zi)==1){
                        $zi="0".$zi;
                    }?>
                    <div class="zi_pontaj">
                        <input class="form-control" readonly name="zi[]" value="{{$zi}}">
                    </div>
                @endfor
                <div class="zi_pontaj">Ore</div>
                @for($zi=1;$zi<=$nr_zile_luna; $zi++)
                    <?php if(strlen($zi)==1){
                        $zi="0".$zi;
                    }?>
                    <div class="zi_pontaj">
                        <input class="form-control" name="nr_ore[]" <?=($status_pontaj?'readonly':'')?> value="<?=(isset($pontaje[$zi])?$pontaje[$zi]:'')?>">
                    </div>
                @endfor
            </div>
            @if(!$status_pontaj)
                <input type='submit' class='btn btn-primary btn-lg mt-2' value='<?=($action=='modifica'?'Salveaza':'Adauga')?>' />
            @endif
        </div>
    </div>
</div>
@endsection
@push('javascript')

@endpush