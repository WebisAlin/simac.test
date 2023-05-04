@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
    <div class="card-body">
        <form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
            @csrf
            <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_curs' value='".$cursValutar->id_curs."' />";
         }?>
            <div class="form-group">
                <label>Luna</label>
                <select name='luna_an_curs_valutar' class='form-control'>
                    <option value=''>Selecteaza luna</option>
                    <option value='1'
                        <?=($action=='modifica' && $cursValutar->luna_an_curs_valutar == '1'?'selected':'')?>>Ianuarie
                    </option>
                    <option value='2'
                        <?=($action=='modifica' && $cursValutar->luna_an_curs_valutar == '2'?'selected':'')?>>Februarie
                    </option>
                    <option value='3'
                        <?=($action=='modifica' && $cursValutar->luna_an_curs_valutar == '3'?'selected':'')?>>Martie
                    </option>
                    <option value='4'
                        <?=($action=='modifica' && $cursValutar->luna_an_curs_valutar == '4'?'selected':'')?>>Aprilie
                    </option>
                    <option value='5'
                        <?=($action=='modifica' && $cursValutar->luna_an_curs_valutar == '5'?'selected':'')?>>Mai</option>
                    <option value='6'
                        <?=($action=='modifica' && $cursValutar->luna_an_curs_valutar == '6'?'selected':'')?>>Iunie
                    </option>
                    <option value='7'
                        <?=($action=='modifica' && $cursValutar->luna_an_curs_valutar == '7'?'selected':'')?>>Iulie
                    </option>
                    <option value='8'
                        <?=($action=='modifica' && $cursValutar->luna_an_curs_valutar == '8'?'selected':'')?>>August
                    </option>
                    <option value='9'
                        <?=($action=='modifica' && $cursValutar->luna_an_curs_valutar == '9'?'selected':'')?>>Septembrie
                    </option>
                    <option value='10'
                        <?=($action=='modifica' && $cursValutar->luna_an_curs_valutar == '10'?'selected':'')?>>Octombrie
                    </option>
                    <option value='11'
                        <?=($action=='modifica' && $cursValutar->luna_an_curs_valutar == '11'?'selected':'')?>>Noiembrie
                    </option>
                    <option value='12'
                        <?=($action=='modifica' && $cursValutar->luna_an_curs_valutar == '12'?'selected':'')?>>Decembrie
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label>Anul</label>
                <select name="an_curs_valutar" class="form-control">
                    <option value="">Selecteaza anul</option>
                    <?php
                    $currentYear = date("Y");
                    for ($i = 0; $i < 3; $i++) {
                        $year = $currentYear - $i;
                        echo '<option value="' . $year . '" '.($action=='modifica' && $cursValutar->an_curs_valutar == $year?'selected':'').'>' . $year . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Moneda</label>
                <select name='valuta' class='form-control'>
                    <option value=''>Selecteaza moneda</option>
                    <option value='dolar' <?=($action=='modifica' && $cursValutar->valuta == 'dolar'?'selected':'')?>>DOLAR
                    </option>
                    <option value='euro' <?=($action=='modifica' && $cursValutar->valuta == 'euro'?'selected':'')?>>EURO
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label>Valoare curs valutar</label>
                <input type='number' step='0.0001' value='<?=($action=='modifica'?$cursValutar->valoare_curs_valutar:'')?>'
                    class='form-control' name='valoare_curs_valutar' placeholder='Valoare curs valutar'>
            </div>
            <input type='submit' class='btn btn-primary btn-lg btn-fix'
                value='<?=($action=='modifica'?'Modifica':'Adauga')?>' />
        </form>
    </div>
</div>
@endsection
