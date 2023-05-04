@extends('layouts.didactic')
@section('content')
<div class="card">
    <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
    <div class="card-body">
        <form action="{{ route('didactic.cereri-granturi.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-9 text-right"></div>
                <div class="col-md-3 text-center">
                    <h6>
                        APROBAT <br>
                        RECTOR, <br>
                        Prof. Dr. ing. Vasile Topa <br>
                    </h6>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <h6>CERERE<br>
                        de grant-suport conform HCA 135 / 15.12.2020 și de stimulare a publicării în reviste indexate
                        <br>
                        Web of Science (ISI) cu factor de impact (FI) conform HCA 11 / 25.01.2023 și HCA 139 /
                        14.12.2021
                    </h6>
                </div>
            </div>
            <table class="table table-bordered mt-5">
                <thead>
                    <tr>
                        <th></th>
                        <th>Tip cerere</th>
                        <th>Nr. Anexă</th>
                        <th>Hotărâre CA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row"><input name="nr_anexa1" class="checkbox-grup" type="checkbox" ></th>
                        <th>Cerere de grant-suport pentru publicații științifice în reviste indexate Web of Science
                            (ISI) cu
                            factor de impact (FI)</th>
                        <th>1 </th>
                        <th>135 / 2020</th>
                    </tr>
                    <tr>
                        <th scope="row"><input name="nr_anexa2" class="checkbox-grup" type="checkbox" ></th>
                        <th>Cerere de finanțare conform HCA Nr. 11 din 25.01.2023 (Art. 2.1.) / HCA Nr. 139 din
                            14.12.2021
                            (Art. 1.1.)</th>
                        <th>2</th>
                        <th>11/2023, 139/2021 </th>
                    </tr>
                    <tr>
                        <th scope="row"><input name="nr_anexa3" class="checkbox-grup" type="checkbox" ></th>
                        <th>Cerere de finanțare conform HCA Nr. 11 din 25.01.2023 (Art. 2.2.) / HCA Nr. 139 din
                            14.12.2021
                            (Art. 1.2.) </th>
                        <th>3</th>
                        <th>11/2023, 139/2021</th>
                    </tr>
                    <tr>
                        <th scope="row"><input name="nr_anexa4" class="checkbox-grup" type="checkbox" ></th>
                        <th>Cerere de grant-suport pentru Brevete</th>
                        <th>4</th>
                        <th>135 / 2020</th>
                    </tr>
                    <tr>
                        <th scope="row"><input name="nr_anexa5" class="checkbox-grup" type="checkbox" ></th>
                        <th>Cerere de grant-suport pentru Citări</th>
                        <th>5</th>
                        <th>135 / 2020</th>
                    </tr>
                    <tr>
                        <th scope="row"><input name="nr_anexa6" class="checkbox-grup" type="checkbox" ></th>
                        <th>Cerere de grant-suport pentru Premii ale Academiei Române sau ale unor Organizații
                            Internaționale</th>
                        <th>6</th>
                        <th>135 / 2020</th>
                    </tr>
                </tbody>
            </table>
            <div class="row mt-5">
                <div class="col-md-12 text-left">
                    <h6>Date de contact:</h6>
                </div>
            </div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th class="col-2" style="vertical-align: middle;">Nume și Prenume:</th>
                        <th class="col-10"><input type='text'
                                value='<?=($action=='adauga' ? $cadruDidactic->nume_cd.' '.$cadruDidactic->prenume_cd: '')?>'
                                class='form-control' name='nume_grant' placeholder='Nume si prenume' required></th>
                    </tr>
                    <tr>
                        <th class="col-2" style="vertical-align: middle;">Facultate:</th>
                        <th class="col-10"><input type='text'
                                value='<?=($action=='adauga' ? $cadruDidactic->facultate->nume_facultate: '')?>'
                                class='form-control' name='nume_facultate' placeholder='Facultate' required></th>
                    </tr>
                    <tr>
                        <th class="col-2" style="vertical-align: middle;">Departament:</th>
                        <th class="col-10"><input type='text'
                                value='<?=($action=='adauga' ? $cadruDidactic->departament->nume_departament: '')?>'
                                class='form-control' name='nume_departament' placeholder='Departament' required></th>
                    </tr>
                    <tr>
                        <th class="col-2" style="vertical-align: middle;">Telefon la birou:</th>
                        <th class="col-10"><input type='text'
                                value='<?=($action=='adauga' ? $cadruDidactic->telefon_cd: '')?>' class='form-control'
                                name='telefon_birou_grant' placeholder='Telefon la birou' required></th>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th class="col-2" style="vertical-align: middle;">Telefon mobil:</th>
                        <th class="col-4"><input type='text' value='' class='form-control' name='telefon_grant'
                                placeholder='Telefon mobil' required></th>
                        <th class="col-1" style="vertical-align: middle;">E-mail:</th>
                        <th class="col-5"><input type='text'
                                value='<?=($action=='adauga' ? $cadruDidactic->email_cd: '')?>' class='form-control'
                                name='email_grant' placeholder='E-mail' required></th>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th style="vertical-align: middle;">Numai pentru doctoranzi:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="col-2" style="vertical-align: middle;">Nume și Prenume:</th>
                        <th class="col-10"><input type='text' value='' class='form-control' name='nume_doctorand_grant'
                                placeholder='Nume si prenume'></th>
                    </tr>
                    <tr>
                        <th class="col-2" style="vertical-align: middle;">Doctorand din anul:</th>
                        <th class="col-10"><input type='text' value='' class='form-control' name='an_doctorand_grant'
                                placeholder='Doctorand din anul'></th>
                    </tr>
                    <tr>
                        <th class="col-4" style="vertical-align: middle;">Conducător de doctorat: (grad didactic, nume,
                            prenume)</th>
                        <th class="col-8"><input type='text' value='' class='form-control'
                                name='conducator_doctorand_grant' placeholder='Conducător de doctorat'></th>
                    </tr>
                </tbody>
            </table>
            <div class="row mt-5">
                <div class="col-md-12 text-left">
                    <h6>Data: {{ $data }}</h6>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12 text-left">
                    <ul>
                        <li>Cererea se completează obligatoriu ELECTRONIC împreună cu anexele selectate, după care se
                            listează.</li>
                        <li>Cererea se completează pentru o singură lucrare ISI. Mai multe lucrări fac obiectul mai
                            multor
                            cereri.</li>
                        <li>Cererea se depune prin registratură, către Z-CERCET-Granturi.</li>
                        <li>Vă rugăm NU modificați structura și formatul documentului!</li>
                        <li>Pentru fiecare lucrare, brevet se va face solicitarea de către unul din autori.</li>
                        <li>Se vor trece obligatoriu datele de contact ale autorului solicitant.</li>
                    </ul>
                </div>
            </div>
            <div class="row pt-4">
                <div class="col-lg-12 text-right">
                    <button type="submit" class="btn btn-primary">Pasul urmator</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
