@extends('layouts.didactic')
@section('content')
<div class="card">
    <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
    <div class="card-body rezumat-proiect">
        <div class="form-group">
            <label>Denumire proiect</label>
            <?php echo $proiect->denumire_proiect; ?>
        </div>
        <div class="form-group">
            <label>Cod proiect</label>
            <?php echo $proiect->cod_proiect; ?>
        </div>
        <div class="form-group">
            <label>Director de proiect </label>
            <?php echo $proiect->director->nume_cd." ".$proiect->director->prenume_cd; ?>
        </div>
        <div class="form-group">
            <label>Tip proiect </label>
            <?php echo ($proiect->tip_proiect->parinteMostenit?$proiect->tip_proiect->parinteMostenit->tip_proiect." > ".$proiect->tip_proiect->tip_proiect:''); ?>
        </div>
        <div class="form-group">
            <label>Valoare </label>
            <?php echo $proiect->valoare_proiect." ".$proiect->moneda_proiect;; ?>
        </div>
        <div class="form-group">
            <label>Data inceput </label>
            <?php echo date('d-m-Y', strtotime($proiect->data_inceput_proiect)); ?>
        </div>
        <div class="form-group">
            <label>Data final</label>
            <?php echo date('d-m-Y', strtotime($proiect->data_final_proiect)); ?>
        </div>
        <div class="form-group">
            <label>Nr. contract</label>
            <?php echo $proiect->nr_contract; ?>
        </div>
        <div class="form-group">
            <label>Pagina web</label>
            <?php echo $proiect->pagina_web; ?>
        </div>
    </div>
</div>
@endsection
