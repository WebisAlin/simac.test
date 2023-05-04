@extends('layouts.admin')
@section('content')
<form method='post' action="<?=$actionForm?>" enctype="multipart/form-data">
        @csrf
            <?php if($action=="modifica"){
            echo "<input type='hidden' name='_method' value='PUT'>
            <input type='hidden' name='id_grant_cerere' value='".$grant_cerere->id_grant_cerere."' />";
            }?>
<div class="card">
    <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
    <div class="card-body">
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
                        <th scope="row"><input name="nr_anexa1" class="checkbox-grup" type="checkbox"
                                <?=($action=='modifica' && $grant_cerere->anexa1 ? 'checked': '')?> disabled></th>
                        <th>Cerere de grant-suport pentru publicații științifice în reviste indexate Web of Science
                            (ISI) cu
                            factor de impact (FI)</th>
                        <th>1 </th>
                        <th>135 / 2020</th>
                    </tr>
                    <tr>
                        <th scope="row"><input name="nr_anexa2" class="checkbox-grup" type="checkbox"
                                <?=($action=='modifica' && $grant_cerere->anexa2 ? 'checked': '')?> disabled></th>
                        <th>Cerere de finanțare conform HCA Nr. 11 din 25.01.2023 (Art. 2.1.) / HCA Nr. 139 din
                            14.12.2021
                            (Art. 1.1.)</th>
                        <th>2</th>
                        <th>11/2023, 139/2021 </th>
                    </tr>
                    <tr>
                        <th scope="row"><input name="nr_anexa3" class="checkbox-grup" type="checkbox"
                                <?=($action=='modifica' && $grant_cerere->anexa3 ? 'checked': '')?> disabled></th>
                        <th>Cerere de finanțare conform HCA Nr. 11 din 25.01.2023 (Art. 2.2.) / HCA Nr. 139 din
                            14.12.2021
                            (Art. 1.2.) </th>
                        <th>3</th>
                        <th>11/2023, 139/2021</th>
                    </tr>
                    <tr>
                        <th scope="row"><input name="nr_anexa4" class="checkbox-grup" type="checkbox"
                                <?=($action=='modifica' && $grant_cerere->anexa4 ? 'checked': '')?> disabled></th>
                        <th>Cerere de grant-suport pentru Brevete</th>
                        <th>4</th>
                        <th>135 / 2020</th>
                    </tr>
                    <tr>
                        <th scope="row"><input name="nr_anexa5" class="checkbox-grup" type="checkbox"
                                <?=($action=='modifica' && $grant_cerere->anexa5 ? 'checked': '')?> disabled></th>
                        <th>Cerere de grant-suport pentru Citări</th>
                        <th>5</th>
                        <th>135 / 2020</th>
                    </tr>
                    <tr>
                        <th scope="row"><input name="nr_anexa6" class="checkbox-grup" type="checkbox"
                                <?=($action=='modifica' && $grant_cerere->anexa6 ? 'checked': '')?> disabled></th>
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
                                value='<?=($action=='modifica' ? $grant_cerere->nume_grant: '')?>' class='form-control'
                                name='nume_grant' placeholder='Nume si prenume' required></th>
                    </tr>
                    <tr>
                        <th class="col-2" style="vertical-align: middle;">Facultate:</th>
                        <th class="col-10"><input type='text'
                                value='<?=($action=='modifica' ? $grant_cerere->nume_facultate: '')?>'
                                class='form-control' name='nume_facultate' placeholder='Facultate' required></th>
                    </tr>
                    <tr>
                        <th class="col-2" style="vertical-align: middle;">Departament:</th>
                        <th class="col-10"><input type='text'
                                value='<?=($action=='modifica' ? $grant_cerere->nume_departament: '')?>'
                                class='form-control' name='nume_departament' placeholder='Departament' required></th>
                    </tr>
                    <tr>
                        <th class="col-2" style="vertical-align: middle;">Telefon la birou:</th>
                        <th class="col-10"><input type='text'
                                value='<?=($action=='modifica' ? $grant_cerere->telefon_birou_grant: '')?>'
                                class='form-control' name='telefon_birou_grant' placeholder='Telefon la birou' required>
                        </th>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th class="col-2" style="vertical-align: middle;">Telefon mobil:</th>
                        <th class="col-4"><input type='text'
                                value='<?=($action=='modifica' ? $grant_cerere->telefon_grant: '')?>'
                                class='form-control' name='telefon_grant' placeholder='Telefon mobil' required></th>
                        <th class="col-1" style="vertical-align: middle;">E-mail:</th>
                        <th class="col-5"><input type='text'
                                value='<?=($action=='modifica' ? $grant_cerere->email_grant: '')?>' class='form-control'
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
                        <th class="col-10"><input type='text'
                                value='<?=($action=='modifica' ? $grant_cerere->nume_doctorand_grant: '')?>'
                                class='form-control' name='nume_doctorand_grant' placeholder='Nume si prenume'></th>
                    </tr>
                    <tr>
                        <th class="col-2" style="vertical-align: middle;">Doctorand din anul:</th>
                        <th class="col-10"><input type='text'
                                value='<?=($action=='modifica' ? $grant_cerere->an_doctorand_grant: '')?>'
                                class='form-control' name='an_doctorand_grant' placeholder='Doctorand din anul'></th>
                    </tr>
                    <tr>
                        <th class="col-4" style="vertical-align: middle;">Conducător de doctorat: (grad didactic, nume,
                            prenume)</th>
                        <th class="col-8"><input type='text'
                                value='<?=($action=='modifica' ? $grant_cerere->conducator_doctorand_grant: '')?>'
                                class='form-control' name='conducator_doctorand_grant'
                                placeholder='Conducător de doctorat'></th>
                    </tr>
                </tbody>
            </table>
            <div class="row mt-5">
                <div class="col-md-12 text-left">
                    <h6>Data: <?=($action=='modifica' ? $grant_cerere->data_grant: '')?></h6>
                </div>
                <input type='hidden' value='<?=($action=='modifica' ? $grant_cerere->data_grant: '')?>' name='data_grant'>
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
    </div>
</div>
@if($grant_cerere->anexa1)
<div class="card">
    <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9 text-right"></div>
            <div class="col-md-3 text-center">
                <h6>
                    Anexa 1
                </h6>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <h6>CERERE<br>
                    de grant-suport pentru publicații științifice în reviste indexatebr
                    Web of Science (ISI) cu factor de impact (FI)
                </h6>
            </div>
        </div>
        <div>
            <div class="row paddingTop70">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-sm btn-success add-row1"><i class="fa fa-plus"
                            aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-sm btn-danger delete-row1"><i class="fa fa-minus"
                            aria-hidden="true"></i></button>
                </div>
            </div>
            @if (!empty($grant_cerere->anexa1->lista_autori_utcn))
            @php
                $autori = json_decode($grant_cerere->anexa1->lista_autori_utcn, true);
            @endphp
                <table class="table tabela1 table-bordered mt-2">
                    <thead>
                        <tr>
                            <th>Nr. crt.</th>
                            <th>Numele</th>
                            <th>Prenumele</th>
                            <th>Funcţia (Prof/Conf/Sl/Lect/Asist/Drd)</th>
                            <th>Facultate / Departament</th>
                            <th>Semnatura autori</th>
                            <th>Stergere</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($autori != null)
                            @foreach ($autori as $index => $autor)
                                <tr>
                                    <td class="nr-crt">{{ $index + 1 }}</td>
                                    <td><input type='text' value="{{ $autor['nume'] }}" class='form-control' name='nume_din_utcn[]' placeholder='Nume'
                                            required></td>
                                    <td><input type='text' value="{{ $autor['prenume'] }}" class='form-control' name='prenume_din_utcn[]'
                                            placeholder='Prenume' required></td>
                                    <td><input type='text' value="{{ $autor['functia'] }}" class='form-control' name='functia_din_utcn[]'
                                            placeholder='Functia' required></td>
                                    <td><input type='text' value="{{ $autor['facultate'] }}" class='form-control' name='facultate_din_utcn[]'
                                            placeholder='Facultate / Departament' required></td>
                                    <td><input type='file' value='' class='form-control' name='semnatura_din_utcn[]'
                                            placeholder='Semnatura autori' hidden>
                                            @if ($autor['semnatura'])
                                                <img style="margin-top:5px" src="{{env('APP_URL') }}/public/uploads/anexa1/{{$autor['semnatura']}}" height="30">
                                            @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-danger mr-2 p-2 stergereRandTabela" data-anexa='1' data-id='{{$grant_cerere->anexa1->id_anexa1}}'  data-autori='utcn'  data-index='{{$index}}'><i class='fa fa-times'></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        @if($autori == null)
                        <tr>
                            <td class="nr-crt">1</td>
                            <td><input type='text' value='' class='form-control' name='nume_din_utcn[]' placeholder='Nume'
                                    required></td>
                            <td><input type='text' value='' class='form-control' name='prenume_din_utcn[]'
                                    placeholder='Prenume' required></td>
                            <td><input type='text' value='' class='form-control' name='functia_din_utcn[]'
                                    placeholder='Functia' required></td>
                            <td><input type='text' value='' class='form-control' name='facultate_din_utcn[]'
                                    placeholder='Facultate / Departament' required></td>
                            <td><input type='file' value='' class='form-control' name='semnatura_din_utcn[]'
                                    placeholder='Semnatura autori' required></td>
                        </tr>
                        @endif
                        <tr class="hidden-row1" style="display:none;">
                            <td class="nr-crt"></td>
                            <td><input type='text' value='' class='form-control' name='nume_din_utcn[]' placeholder='Nume'>
                            </td>
                            <td><input type='text' value='' class='form-control' name='prenume_din_utcn[]'
                                    placeholder='Prenume'></td>
                            <td><input type='text' value='' class='form-control' name='functia_din_utcn[]'
                                    placeholder='Functia'></td>
                            <td><input type='text' value='' class='form-control' name='facultate_din_utcn[]'
                                    placeholder='Facultate / Departament'></td>
                            <td><input type='file' value='' class='form-control' name='semnatura_din_utcn[]'
                                    placeholder='Semnatura autori'></td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
        <div class="row paddingTop50">
            <div class="col-md-2 d-flex align-items-center">
                <h6 class="mb-0">Autori din străinătate:</h6>
                <input type="checkbox" class="form-control" name="autori_din_strainatate">
            </div>
            <div class="col-md-10 text-right">
                <button type="button" class="btn btn-sm btn-success add-row2"><i class="fa fa-plus"
                        aria-hidden="true"></i></button>
                <button type="button" class="btn btn-sm btn-danger delete-row2"><i class="fa fa-minus"
                        aria-hidden="true"></i></button>
            </div>
        </div>

    
        @if (!empty($grant_cerere->anexa1->lista_autori_din_afara_utcn))
            @php
                $autori = json_decode($grant_cerere->anexa1->lista_autori_din_afara_utcn, true);
            @endphp
                <table class="table tabela2 table-bordered mt-2">
                    <thead>
                        <tr>
                        <th>Nr. crt.</th>
                        <th>Numele</th>
                        <th>Prenumele</th>
                        <th>Funcţia (Prof/Conf/Sl/Lect/Asist/Drd)</th>
                        <th>Facultate / Departament</th>
                        <th>MembrăeUT+</th>
                        <th>Stergere</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($autori != null)
                        @foreach ($autori as $index => $autor)
                                <tr>
                                    <td class="nr-crt">{{ $index + 1 }}</td>
                                    <td><input type='text' value="{{ $autor['nume'] }}" class='form-control' name='nume_din_afara_utcn[]' placeholder='Nume'
                                            required></td>
                                    <td><input type='text' value="{{ $autor['prenume'] }}" class='form-control' name='prenume_din_afara_utcn[]'
                                            placeholder='Prenume' required></td>
                                    <td><input type='text' value="{{ $autor['functia'] }}" class='form-control' name='functia_din_afara_utcn[]'
                                            placeholder='Functia' required></td>
                                    <td><input type='text' value="{{ $autor['afiliere'] }}" class='form-control' name='afiliere_din_afara_utcn[]'
                                            placeholder='Afiliere' required></td>
                                    <td><input type='checkbox' value='1' class='form-control' name='membra_din_afara_utcn[]' <?=($autor['membra'] == 0 ? '': 'checked')?>>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger mr-2 p-2 stergereRandTabela" data-anexa='1' data-id='{{$grant_cerere->anexa1->id_anexa1}}'  data-autori='afara-utcn'  data-index='{{$index}}'><i class='fa fa-times'></i></a>
                                    </td>
                                </tr>
                                
                            @endforeach
                        @endif
                        @if($autori == null)
                        <tr>
                            <td class="nr-crt">1</td>
                            <td><input type='text' value='' class='form-control' name='nume_din_afara_utcn[]' placeholder='Nume'
                                    required></td>
                            <td><input type='text' value='' class='form-control' name='prenume_din_afara_utcn[]'
                                    placeholder='Prenume' required></td>
                            <td><input type='text' value='' class='form-control' name='functia_din_afara_utcn[]'
                                    placeholder='Functia' required></td>
                            <td><input type='text' value='' class='form-control' name='afiliere_din_afara_utcn[]'
                                    placeholder='Afiliere' required></td>
                            <td><input type='checkbox' value='' class='form-control' name='membra_din_afara_utcn[]' required>
                            </td>
                        </tr>
                        @endif
                        <tr class="hidden-row2" style="display:none;">
                            <td class="nr-crt"></td>
                            <td><input type='text' value='' class='form-control' name='nume_din_afara_utcn[]'
                                    placeholder='Nume'></td>
                            <td><input type='text' value='' class='form-control' name='prenume_din_afara_utcn[]'
                                    placeholder='Prenume'></td>
                            <td><input type='text' value='' class='form-control' name='functia_din_afara_utcn[]'
                                    placeholder='Functia'></td>
                            <td><input type='text' value='' class='form-control' name='afiliere_din_afara_utcn[]'
                                    placeholder='Afiliere'></td>
                            <td><input type='checkbox' value='1' class='form-control' name='membra_din_afara_utcn[]'></td>
                        </tr>
                    </tbody>
                </table>
            @endif
        <div class="row paddingTop50">
            <div class="col-md-2">
                <h6 class="mb-0">Articol şi revista:</h6>
                <p class="mb-0">Tipul publicației :</p>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="col-11" style="vertical-align: middle;">ISI Q1 – Top 5% sau în primele 3
                                poziții (cf. JCR category)</th>
                            <th class="col-1 "><input name="tip_publicatie" type="checkbox" value="1" <?=($action=='modifica' && $grant_cerere->anexa1->tip_publicatie == 1 ? 'checked': '')?>></th>
                        </tr>
                        <tr>
                            <th class="col-11" style="vertical-align: middle;">ISI Q1</th>
                            <th class="col-1"><input name="tip_publicatie" type="checkbox" value="2" <?=($action=='modifica' && $grant_cerere->anexa1->tip_publicatie == 2 ? 'checked': '')?>></th>
                        </tr>
                        <tr>
                            <th class="col-11" style="vertical-align: middle;">ISI Q2</th>
                            <th class="col-1"><input name="tip_publicatie" type="checkbox" value="3" <?=($action=='modifica' && $grant_cerere->anexa1->tip_publicatie == 3 ? 'checked': '')?>></th>
                        </tr>
                        <tr>
                            <th class="col-11" style="vertical-align: middle;">ISI – Arts & Humanities</th>
                            <th class="col-1"><input name="tip_publicatie" type="checkbox" value="4" <?=($action=='modifica' && $grant_cerere->anexa1->tip_publicatie == 4 ? 'checked': '')?>></th>
                        </tr>
                        <tr>
                            <th class="col-11" style="vertical-align: middle;">Erih Plus</th>
                            <th class="col-1"><input name="tip_publicatie" type="checkbox" value="5" <?=($action=='modifica' && $grant_cerere->anexa1->tip_publicatie == 5 ? 'checked': '')?>></th>
                        </tr>
                        <tr>
                            <th class="col-11" style="vertical-align: middle;">Nature</th>
                            <th class="col-1"><input name="tip_publicatie" type="checkbox" value="6" <?=($action=='modifica' && $grant_cerere->anexa1->tip_publicatie == 6 ? 'checked': '')?>></th>
                        </tr>
                        <tr>
                            <th class="col-11" style="vertical-align: middle;">Monografii</th>
                            <th class="col-1"><input name="tip_publicatie" type="checkbox" value="7" <?=($action=='modifica' && $grant_cerere->anexa1->tip_publicatie == 7 ? 'checked': '')?>></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="col-11" style="vertical-align: middle;">Open Access</th>
                            <th class="col-1"><input name="open_access" type="checkbox" value="" <?=($action=='modifica' && $grant_cerere->anexa1->open_access == 1 ? 'checked': '')?>></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-2 d-flex align-items-center">
                <h6 class="mb-0">Detalii publicare:</h6>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" name="detalii_publicare" value='<?=($action=='modifica' ? $grant_cerere->anexa1->detalii_publicare: '')?>' placeholder="Detalii publicare"
                    required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 d-flex align-items-center">
                <h6 class="mb-0">Titlul lucrării:</h6>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" name="titlul_lucrarii" value='<?=($action=='modifica' ? $grant_cerere->anexa1->titlul_lucrarii: '')?>' placeholder="Titlul lucrării" required>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-2 d-flex align-items-center">
                <h6 class="mb-0">Denumirea revistei:</h6>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" name="denumirea_revistei" value='<?=($action=='modifica' ? $grant_cerere->anexa1->denumirea_revistei: '')?>' placeholder="Denumirea revistei"
                    required>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-2 d-flex align-items-center">
                <h6 class="mb-0">Vol:</h6>
            </div>
            <div class="col-md-10">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="col-1" style="vertical-align: middle;"> <input type="text" class="form-control"
                                    name="vol" placeholder="Vol" value='<?=($action=='modifica' ? $grant_cerere->anexa1->vol: '')?>' required>
                            </th>
                            <th class="col-1 " style="vertical-align: middle;">Nr:</th>
                            <th class="col-1" style="vertical-align: middle;"><input type="number" class="form-control"
                                    name="nr" placeholder="Nr" value='<?=($action=='modifica' ? $grant_cerere->anexa1->nr: '')?>' required>
                            </th>
                            <th class="col-1 " style="vertical-align: middle;">An:</th>
                            <th class="col-1" style="vertical-align: middle;"><input type="number" class="form-control"
                                    name="an" placeholder="An" value='<?=($action=='modifica' ? $grant_cerere->anexa1->an: '')?>' required></th>
                            <th class="col-1 " style="vertical-align: middle;">Luna</th>
                            <th class="col-1" style="vertical-align: middle;"><input type="number" class="form-control"
                                    name="luna" placeholder="Luna" value='<?=($action=='modifica' ? $grant_cerere->anexa1->luna: '')?>' required></th>
                            <th class="col-1 " style="vertical-align: middle;">Pag încep:</th>
                            <th class="col-1" style="vertical-align: middle;"><input type="text" class="form-control"
                                    name="pag_incep" placeholder="Pag încep" value='<?=($action=='modifica' ? $grant_cerere->anexa1->pag_incep: '')?>'required>
                            </th>
                            <th class="col-1 " style="vertical-align: middle;">Pag sfârşit:</th>
                            <th class="col-1" style="vertical-align: middle;"><input type="text" class="form-control"
                                    name="pag_sfarsit" placeholder="Pag sfârşit" value='<?=($action=='modifica' ? $grant_cerere->anexa1->pag_sfarsit: '')?>' required>
                            </th>
                        </tr>
                    </tbody>
                </table>
                <p>*Anul publicării nu apariției de tip Early Access</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-2 ">
                <h6 class="mb-0">ISSN/ISBN:</h6><br>
                <h6 class="mb-0">DOI sau WOS:</h6>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="issn_isbn" value='<?=($action=='modifica' ? $grant_cerere->anexa1->issn_isbn: '')?>' placeholder="ISSN/ISBN" required>
                <input type="text" class="form-control" name="doi_wos" value='<?=($action=='modifica' ? $grant_cerere->anexa1->doi_wos: '')?>' placeholder="DOI sau WOS" required>
            </div>
            <div class="col-md-3 d-flex align-items-center">
                <h6 class="mb-0">Factor de impact în anul anterior publicării</h6>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control mt-4" value='<?=($action=='modifica' ? $grant_cerere->anexa1->factor_impact: '')?>' name="factor_impact" required>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12 d-flex align-items-center">
                <h6 class="mb-0">Ataşez următoarele documente justificative:</h6>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 d-flex align-items-center">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="col-1" style="vertical-align: middle;">1. Dovada publicării și indexării în
                                Web of Science cu specificarea zonei de încadrare
                                <input class="form-control mt-4 mb-3" type="file" name="dovada_publicarii[]" multiple="true" accept="image/jpeg, image/png, image/gif,">
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 d-flex align-items-center">
                <table class="table table-bordered">
                    <tbody>
                    @if($action=='modifica' && $grant_cerere->anexa1->dovada_publicarii)
                        @foreach (unserialize($grant_cerere->anexa1->dovada_publicarii) as $file)
                        <tr>
                            <th class="col-11" style="vertical-align: middle;"><a href="{{env('APP_URL')}}/public/uploads/anexa1/{{$file}}" target="_blank">Download {{$file}}</a></th>
                            <th class="col-1" style="vertical-align: middle;"><a class="btn btn-danger mr-2 p-2 stergereAtasamentAnexa" data-anexa='1' data-id='{{$grant_cerere->anexa1->id_anexa1}}' data-fisier='{{$file}}'><i class='fa fa-times'></i></a></th>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 d-flex align-items-center">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="col-1" style="vertical-align: middle;">2. Copie articol publicat
                                <input class="form-control mt-4 mb-3" type="file" name="copie_articol[]" multiple="true" accept="image/jpeg, image/png, image/gif,">
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 d-flex align-items-center">
                <table class="table table-bordered">
                    <tbody>
                    @if($action=='modifica' && $grant_cerere->anexa1->copie_articol)
                        @foreach (unserialize($grant_cerere->anexa1->copie_articol) as $file)
                        <tr>
                            <th class="col-11" style="vertical-align: middle;"><a href="{{env('APP_URL')}}/public/uploads/anexa1/{{$file}}" target="_blank">Download {{$file}}</a></th>
                            <th class="col-1" style="vertical-align: middle;"><a class="btn btn-danger mr-2 p-2 stergereAtasamentAnexa" data-anexa='1.5' data-id='{{$grant_cerere->anexa1->id_anexa1}}' data-fisier='{{$file}}'><i class='fa fa-times'></i></a></th>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@if($grant_cerere->anexa2)
<div class="card">
    <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9 text-right"></div>
            <div class="col-md-3 text-center">
                <h6>
                    Anexa 2
                </h6>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <h6>CERERE<br><br>
                    de finanțare conform HCA Nr. 11 din 25.01.2023 (Art.2.1.)
                    (această anexă se completează împreună cu Anexa 1)
                </h6>
            </div>
        </div>
        <div>
            <div class="row paddingTop70">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-sm btn-success add-row3"><i class="fa fa-plus"
                            aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-sm btn-danger delete-row3"><i class="fa fa-minus"
                            aria-hidden="true"></i></button>
                </div>
            </div>
            @if (!empty($grant_cerere->anexa2->lista_autori_utcn))
            @php
                $autori = json_decode($grant_cerere->anexa2->lista_autori_utcn, true);
            @endphp
                <table class="table tabela3 table-bordered mt-2">
                    <thead>
                        <tr>
                            <th>Nr. crt.</th>
                            <th>Numele</th>
                            <th>Prenumele</th>
                            <th>Funcţia (Prof/Conf/Sl/Lect/Asist/Drd)</th>
                            <th>Facultate / Departament</th>
                            <th>Semnatura autori</th>
                            <th>Stergere</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($autori != null)
                            @foreach ($autori as $index => $autor)
                                <tr>
                                    <td class="nr-crt">{{ $index + 1 }}</td>
                                    <td><input type='text' value="{{ $autor['nume'] }}" class='form-control' name='nume_din_utcn[]' placeholder='Nume'
                                            required></td>
                                    <td><input type='text' value="{{ $autor['prenume'] }}" class='form-control' name='prenume_din_utcn[]'
                                            placeholder='Prenume' required></td>
                                    <td><input type='text' value="{{ $autor['functia'] }}" class='form-control' name='functia_din_utcn[]'
                                            placeholder='Functia' required></td>
                                    <td><input type='text' value="{{ $autor['facultate'] }}" class='form-control' name='facultate_din_utcn[]'
                                            placeholder='Facultate / Departament' required></td>
                                    <td><input type='file' value='' class='form-control' name='semnatura_din_utcn[]'
                                            placeholder='Semnatura autori' hidden>
                                            @if ($autor['semnatura'])
                                                <img style="margin-top:5px" src="{{env('APP_URL') }}/public/uploads/anexa2/{{$autor['semnatura']}}" height="30">
                                            @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-danger mr-2 p-2 stergereRandTabela" data-anexa='2' data-id='{{$grant_cerere->anexa2->id_anexa2}}'  data-autori='utcn'  data-index='{{$index}}'><i class='fa fa-times'></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        @if($autori == null)
                        <tr>
                            <td class="nr-crt">1</td>
                            <td><input type='text' value='' class='form-control' name='nume_din_utcn[]' placeholder='Nume'
                                    required></td>
                            <td><input type='text' value='' class='form-control' name='prenume_din_utcn[]'
                                    placeholder='Prenume' required></td>
                            <td><input type='text' value='' class='form-control' name='functia_din_utcn[]'
                                    placeholder='Functia' required></td>
                            <td><input type='text' value='' class='form-control' name='facultate_din_utcn[]'
                                    placeholder='Facultate / Departament' required></td>
                            <td><input type='file' value='' class='form-control' name='semnatura_din_utcn[]'
                                    placeholder='Semnatura autori' required></td>
                        </tr>
                        @endif
                        <tr class="hidden-row3" style="display:none;">
                            <td class="nr-crt"></td>
                            <td><input type='text' value='' class='form-control' name='nume_din_utcn[]' placeholder='Nume'>
                            </td>
                            <td><input type='text' value='' class='form-control' name='prenume_din_utcn[]'
                                    placeholder='Prenume'></td>
                            <td><input type='text' value='' class='form-control' name='functia_din_utcn[]'
                                    placeholder='Functia'></td>
                            <td><input type='text' value='' class='form-control' name='facultate_din_utcn[]'
                                    placeholder='Facultate / Departament'></td>
                            <td><input type='file' value='' class='form-control' name='semnatura_din_utcn[]'
                                    placeholder='Semnatura autori'></td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
        <div class="row paddingTop50">
            <div class="col-md-2 d-flex align-items-center">
                <h6 class="mb-0">Autori din eUT:</h6>
                <input type="checkbox" class="form-control" name="autori_din_eUT"  <?=($action=='modifica' && $grant_cerere->anexa2->autori_din_eUT == 1 ? 'checked': '')?>>
            </div>
            <div class="col-md-10 text-right"></div>
        </div>
    </div>
</div>
@endif
@if($grant_cerere->anexa3)
<div class="card">
    <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9 text-right"></div>
            <div class="col-md-3 text-center">
                <h6>
                    Anexa 3
                </h6>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <h6>CERERE<br>
                    de finanțare conform HCA Nr. 11 din 25.01.2023 (Art.2.2.) <br>
                    (această anexă se completează împreună cu Anexa 1)
                </h6>
            </div>
        </div>
        <div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 d-flex align-items-center">
                <h6 class="mb-0">Date propunere:</h6>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="col-4" style="vertical-align: middle;">Finanțator:</th>
                            <th class="col-8"><input type="text" class="form-control" value='<?=($action=='modifica' ? $grant_cerere->anexa3->finantator: '')?>' name="finantator"
                                    placeholder="Finanțator" required></th>
                        </tr>
                        <tr>
                            <th class="col-4" style="vertical-align: middle;">Program:</th>
                            <th class="col-8"><input type="text" class="form-control"  value='<?=($action=='modifica' ? $grant_cerere->anexa3->program: '')?>' name="program"
                                    placeholder="Program" required></th>
                        </tr>
                        <tr>
                            <th class="col-4" style="vertical-align: middle;">An competiție:</th>
                            <th class="col-8"><input type="number" class="form-control"  value='<?=($action=='modifica' ? $grant_cerere->anexa3->an_competitie: '')?>' name="an_competitie"
                                    placeholder="An competiție" required></th>
                        </tr>
                        <tr>
                            <th class="col-4" style="vertical-align: middle;">Titlu propunere proiect:</th>
                            <th class="col-8"><input type="text" class="form-control"  value='<?=($action=='modifica' ? $grant_cerere->anexa3->titlu_propunere: '')?>' name="titlu_propunere"
                                    placeholder="Titlu propunere proiect" required></th>
                        </tr>
                        <tr>
                            <th class="col-4" style="vertical-align: middle;">Cod propunere:</th>
                            <th class="col-8"><input type="text" class="form-control"  value='<?=($action=='modifica' ? $grant_cerere->anexa3->cod_propunere: '')?>' name="cod_propunere"
                                    placeholder="Cod propunere" required></th>
                        </tr>
                        <tr>
                            <th class="col-4" style="vertical-align: middle;">Calitate în propunere:</th>
                            <th class="col-8"><input type="text" class="form-control"  value='<?=($action=='modifica' ? $grant_cerere->anexa3->calitate_propunere: '')?>' name="calitate_propunere"
                                    placeholder="Calitate în propunere" required></th>
                        </tr>
                        <tr>
                            <th class="col-4" style="vertical-align: middle;">Punctaj obținut:</th>
                            <th class="col-8"><input type="number" class="form-control"  value='<?=($action=='modifica' ? $grant_cerere->anexa3->punctaj_obtinut: '')?>' name="punctaj_obtinut"
                                    placeholder="Punctaj obținut" required></th>
                        </tr>
                        <tr>
                            <th class="col-4" style="vertical-align: middle;">Punctaj maxim competiție**:</th>
                            <th class="col-8"><input type="number" class="form-control"  value='<?=($action=='modifica' ? $grant_cerere->anexa3->punctaj_maxim_competitie: '')?>' name="punctaj_maxim_competitie"
                                    placeholder="Punctaj maxim competiție" required></th>
                        </tr>
                        <tr>
                            <th class="col-4" style="vertical-align: middle;">Procent [%]:</th>
                            <th class="col-8"><input type="number" class="form-control"  value='<?=($action=='modifica' ? $grant_cerere->anexa3->procent: '')?>' name="procent"
                                    placeholder="Procent" required></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 d-flex align-items-center">
                <h6 class="mb-0">* Doar in cazul competițiilor Horizon <br>
                    ** Se anexează dovezile (fișa de evaluare, link spre rezultate publice, extras din pachet
                    informații sau alte documente din care să rezulte punctajul obținut, respectiv punctajul maxim
                    al competiției, și data limită de depunere a propunerilor).
                </h6>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-3 d-flex align-items-center">
                <h6 class="mb-0">Parteneri din eUT+ :</h6>
                <input type="checkbox" class="form-control" name="parteneri_eut" <?=($action=='modifica' && $grant_cerere->anexa3->parteneri_eut == 1 ? 'checked': '')?> placeholder="Parteneri din eUT+"
                    required>
            </div>
            <div class="col-md-9"></div>
        </div>
    </div>
</div>
@endif
@if($grant_cerere->anexa4)
<div class="card">
    <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9 text-right"></div>
            <div class="col-md-3 text-center">
                <h6>
                    Anexa 4
                </h6>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <h6>CERERE<br><br>
                    de grant-suport pentru Brevete
                </h6>
            </div>
        </div>
        <div>
            <div class="row paddingTop50">
                <div class="col-md-2">
                    <h6>Tip brevet :</h6>
                </div>
                <div class="col-md-4">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class="col-4" style="vertical-align: middle;">Triadice:</th>
                                <th class="col-8"><input type="radio" class="form-control" value="1" <?=($action=='modifica' && $grant_cerere->anexa4->tip_brevet == 1 ? 'checked': '')?> name="tip_brevet">
                                </th>
                            </tr>
                            <tr>
                                <th class="col-4" style="vertical-align: middle;">Internationale:</th>
                                <th class="col-8"><input type="radio" class="form-control" value="2" <?=($action=='modifica' && $grant_cerere->anexa4->tip_brevet == 2 ? 'checked': '')?> name="tip_brevet">
                                </th>
                            </tr>
                            <tr>
                                <th class="col-4" style="vertical-align: middle;">Nationale:</th>
                                <th class="col-8"><input type="radio" class="form-control" value="3" <?=($action=='modifica' && $grant_cerere->anexa4->tip_brevet == 3 ? 'checked': '')?> name="tip_brevet">
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    </table>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class="col-2" style="vertical-align: middle;">Număr brevet:</th>
                                <th class="col-10"><input type="number" class="form-control" name="numar_brevet"
                                        placeholder="Număr brevet" value='<?=($action=='modifica' ? $grant_cerere->anexa4->numar_brevet: '')?>' required></th>
                            </tr>
                            <tr>
                                <th class="col-2" style="vertical-align: middle;">Titlu brevet:</th>
                                <th class="col-10"><input type="text" class="form-control" name="titlu_brevet"
                                        placeholder="Titlu brevet" value='<?=($action=='modifica' ? $grant_cerere->anexa4->titlu_brevet: '')?>' required></th>
                            </tr>
                        </tbody>
                    </table>
                    </table>
                </div>
            </div>
            <div class="row paddingTop50">
                <div class="col-md-2 d-flex align-items-center">
                </div>
                <div class="col-md-10 text-right">

                    <button type="button" class="btn btn-sm btn-success add-row4"><i class="fa fa-plus"
                            aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-sm btn-danger delete-row4"><i class="fa fa-minus"
                            aria-hidden="true"></i></button>
                </div>
            </div>
            @if (!empty($grant_cerere->anexa4->lista_autori_utcn))
            @php
                $autori = json_decode($grant_cerere->anexa4->lista_autori_utcn, true);
            @endphp
          
                <table class="table tabela4 table-bordered mt-2">
                    <thead>
                        <tr>
                            <th>Nr. crt.</th>
                            <th>Numele</th>
                            <th>Prenumele</th>
                            <th>Funcţia (Prof/Conf/Sl/Lect/Asist/Drd)</th>
                            <th>Facultate / Departament</th>
                            <th>Semnatura autori</th>
                            <th>Stergere</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($autori != null)
                            @foreach ($autori as $index => $autor)
                                <tr>
                                    <td class="nr-crt">{{ $index + 1 }}</td>
                                    <td><input type='text' value="{{ $autor['nume'] }}" class='form-control' name='nume_din_utcn[]' placeholder='Nume'
                                            required></td>
                                    <td><input type='text' value="{{ $autor['prenume'] }}" class='form-control' name='prenume_din_utcn[]'
                                            placeholder='Prenume' required></td>
                                    <td><input type='text' value="{{ $autor['functia'] }}" class='form-control' name='functia_din_utcn[]'
                                            placeholder='Functia' required></td>
                                    <td><input type='text' value="{{ $autor['facultate'] }}" class='form-control' name='facultate_din_utcn[]'
                                            placeholder='Facultate / Departament' required></td>
                                    <td><input type='file' value="{{ $autor['semnatura'] }}" class='form-control' name='semnatura_din_utcn[]'
                                            placeholder='Semnatura autori' hidden>
                                            @if ($autor['semnatura'])
                                                <img style="margin-top:5px" src="{{env('APP_URL') }}/public/uploads/anexa4/{{$autor['semnatura']}}" height="30">
                                            @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-danger mr-2 p-2 stergereRandTabela" data-anexa='4' data-id='{{$grant_cerere->anexa4->id_anexa4}}'  data-autori='utcn'  data-index='{{$index}}'><i class='fa fa-times'></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        @if($autori == null)
                        <tr>
                            <td class="nr-crt">1</td>
                            <td><input type='text' value='' class='form-control' name='nume_din_utcn[]' placeholder='Nume'
                                    required></td>
                            <td><input type='text' value='' class='form-control' name='prenume_din_utcn[]'
                                    placeholder='Prenume' required></td>
                            <td><input type='text' value='' class='form-control' name='functia_din_utcn[]'
                                    placeholder='Functia' required></td>
                            <td><input type='text' value='' class='form-control' name='facultate_din_utcn[]'
                                    placeholder='Facultate / Departament' required></td>
                            <td><input type='file' value='' class='form-control' name='semnatura_din_utcn[]'
                                    placeholder='Semnatura autori' required></td>
                        </tr>
                        @endif
                        <tr class="hidden-row4" style="display:none;">
                            <td class="nr-crt"></td>
                            <td><input type='text' value='' class='form-control' name='nume_din_utcn[]' placeholder='Nume'>
                            </td>
                            <td><input type='text' value='' class='form-control' name='prenume_din_utcn[]'
                                    placeholder='Prenume'></td>
                            <td><input type='text' value='' class='form-control' name='functia_din_utcn[]'
                                    placeholder='Functia'></td>
                            <td><input type='text' value='' class='form-control' name='facultate_din_utcn[]'
                                    placeholder='Facultate / Departament'></td>
                            <td><input type='file' value='' class='form-control' name='semnatura_din_utcn[]'
                                    placeholder='Semnatura autori'></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            @endif
            <div class="row paddingTop50">
                <div class="col-md-2 d-flex align-items-center">
                </div>
                <div class="col-md-10 text-right">
                    <button type="button" class="btn btn-sm btn-success add-row5"><i class="fa fa-plus"
                            aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-sm btn-danger delete-row5"><i class="fa fa-minus"
                            aria-hidden="true"></i></button>
                </div>
            </div>
            @if (!empty($grant_cerere->anexa4->lista_autori_din_afara_utcn))
            @php
                $autori = json_decode($grant_cerere->anexa4->lista_autori_din_afara_utcn, true);
            @endphp
                <table class="table tabela5 table-bordered mt-2">
                    <thead>
                        <tr>
                        <th>Nr. crt.</th>
                        <th>Numele</th>
                        <th>Prenumele</th>
                        <th>Funcţia (Prof/Conf/Sl/Lect/Asist/Drd)</th>
                        <th>Facultate / Departament</th>
                        <th>MembrăeUT+</th>
                        <th>Stergere</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($autori != null)
                        @foreach ($autori as $index => $autor)
                            <tr>
                                <td class="nr-crt">{{ $index + 1 }}</td>
                                <td><input type='text' value="{{ $autor['nume'] }}" class='form-control' name='nume_din_afara_utcn[]' placeholder='Nume'
                                        required></td>
                                <td><input type='text' value="{{ $autor['prenume'] }}" class='form-control' name='prenume_din_afara_utcn[]'
                                        placeholder='Prenume' required></td>
                                <td><input type='text' value="{{ $autor['functia'] }}" class='form-control' name='functia_din_afara_utcn[]'
                                        placeholder='Functia' required></td>
                                <td><input type='text' value="{{ $autor['afiliere'] }}" class='form-control' name='afiliere_din_afara_utcn[]'
                                        placeholder='Afiliere' required></td>
                                <td><input type='checkbox' value='1' class='form-control' name='membra_din_afara_utcn[]' <?=($autor['membra'] == 0 ? '': 'checked')?>>
                                </td>
                                <td>
                                    <a class="btn btn-danger mr-2 p-2 stergereRandTabela" data-anexa='4' data-id='{{$grant_cerere->anexa4->id_anexa4}}'  data-autori='afara-utcn'  data-index='{{$index}}'><i class='fa fa-times'></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    @if($autori == null)
                    <tr>
                        <td class="nr-crt">1</td>
                        <td><input type='text' value='' class='form-control' name='nume_din_afara_utcn[]' placeholder='Nume'
                                required></td>
                        <td><input type='text' value='' class='form-control' name='prenume_din_afara_utcn[]'
                                placeholder='Prenume' required></td>
                        <td><input type='text' value='' class='form-control' name='functia_din_afara_utcn[]'
                                placeholder='Functia' required></td>
                        <td><input type='text' value='' class='form-control' name='afiliere_din_afara_utcn[]'
                                placeholder='Afiliere' required></td>
                        <td><input type='checkbox' value='1' class='form-control' name='membra_din_afara_utcn[]'>
                        </td>
                        <td></td>
                    </tr>
                    @endif
                        <tr class="hidden-row5" style="display:none;">
                            <td class="nr-crt"></td>
                            <td><input type='text' value='' class='form-control' name='nume_din_afara_utcn[]'
                                    placeholder='Nume'></td>
                            <td><input type='text' value='' class='form-control' name='prenume_din_afara_utcn[]'
                                    placeholder='Prenume'></td>
                            <td><input type='text' value='' class='form-control' name='functia_din_afara_utcn[]'
                                    placeholder='Functia'></td>
                            <td><input type='text' value='' class='form-control' name='afiliere_din_afara_utcn[]'
                                    placeholder='Afiliere'></td>
                            <td><input type='checkbox' value='1' class='form-control' name='membra_din_afara_utcn[]'></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
        <div class="row mt-5">
            <h6>Ataşez următoarele documente justificative:</h6>
            <div class="col-md-12 d-flex align-items-center">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="col-1" style="vertical-align: middle;">1. Dovada obținerii brevetului (copie
                                brevet)
                                <input class="form-control mt-4 mb-3" type="file" name="dovada_brevet[]" multiple="true" accept="image/jpeg, image/png, image/gif,">
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 d-flex align-items-center">
            <table class="table table-bordered">
                    <tbody>
                    @if($action=='modifica' && $grant_cerere->anexa4->dovada_brevet)
                        @foreach (unserialize($grant_cerere->anexa4->dovada_brevet) as $file)
                        <tr>
                            <th class="col-11" style="vertical-align: middle;"><a href="{{env('APP_URL')}}/public/uploads/anexa4/{{$file}}" target="_blank">Download {{$file}}</a></th>
                            <th class="col-1" style="vertical-align: middle;"><a class="btn btn-danger mr-2 p-2 stergereAtasamentAnexa" data-anexa='4' data-id='{{$grant_cerere->anexa4->id_anexa4}}' data-fisier='{{$file}}'><i class='fa fa-times'></i></a></th>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@if($grant_cerere->anexa5)
<div class="card">
    <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9 text-right"></div>
            <div class="col-md-3 text-center">
                <h6>
                    Anexa 5
                </h6>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <h6>CERERE<br>
                    de grant-suport pentru Citări
                </h6>
            </div>
        </div>
        <div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="col-10" style="vertical-align: middle;">Citări independente în publicații
                                indexate Web of Science obținute în an anterior (n)</th>
                            <th class="col-2"><input type="number" class="form-control" name="an_anterior" value='<?=($action=='modifica' ? $grant_cerere->anexa5->an_anterior: '')?>' required>
                            </th>
                        </tr>
                        <tr>
                            <th class="col-10" style="vertical-align: middle;">Citări independente în publicații
                                indexate Web of Science obținute în anul precedent anului anterior (n-1)</th>
                            <th class="col-2"><input type="number" class="form-control" name="an_precedent" value='<?=($action=='modifica' ? $grant_cerere->anexa5->an_precedent: '')?>' required>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <h6>Atașez următoarele documente justificative:</h6>
            <div class="col-md-12 d-flex align-items-center">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="col-1" style="vertical-align: middle;">Dovada citărilor independente din Web
                                of Science – print screen după citation report
                                <input class="form-control mt-4 mb-3" type="file" name="dovada_citari[]" multiple="true" accept="image/jpeg, image/png, image/gif,">
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 d-flex align-items-center">
                <table class="table table-bordered">
                    <tbody>
                    @if($action=='modifica' && $grant_cerere->anexa5->dovada_citari)
                        @foreach (unserialize($grant_cerere->anexa5->dovada_citari) as $file)
                        <tr>
                            <th class="col-11" style="vertical-align: middle;"><a href="{{env('APP_URL')}}/public/uploads/anexa5/{{$file}}" target="_blank">Download {{$file}}</a></th>
                            <th class="col-1" style="vertical-align: middle;"><a class="btn btn-danger mr-2 p-2 stergereAtasamentAnexa" data-anexa='5' data-id='{{$grant_cerere->anexa5->id_anexa5}}' data-fisier='{{$file}}'><i class='fa fa-times'></i></a></th>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@if($grant_cerere->anexa6)
<div class="card">
    <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-9 text-right"></div>
            <div class="col-md-3 text-center">
                <h6>
                    Anexa 6
                </h6>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <h6>CERERE<br>
                    de grant-suport pentru <br>
                    Premii ale Academiei Române sau ale unor Organizații Internaționale
                </h6>
            </div>
        </div>
        <div>
        </div>
        <div class="row paddingTop50">
            <div class="col-md-3 d-flex align-items-center">
                Premiul Academiei Române pentru anul
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" name="an_premiu" value='<?=($action=='modifica' ? $grant_cerere->anexa6->an_premiu: '')?>' required>
            </div>
            <div class="col-md-2 d-flex align-items-center">
                decernat in anul
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="an_decernat" value='<?=($action=='modifica' ? $grant_cerere->anexa6->an_decernat: '')?>' required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 d-flex align-items-center">
                Domeniu
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="domeniu" value='<?=($action=='modifica' ? $grant_cerere->anexa6->domeniu: '')?>' required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 d-flex align-items-center">
                Premiu
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="premiu" value='<?=($action=='modifica' ? $grant_cerere->anexa6->premiu: '')?>'required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 d-flex align-items-center">
                Titlul lucrării
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="titlu_lucrare" value='<?=($action=='modifica' ? $grant_cerere->anexa6->titlu_lucrare: '')?>' required>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 d-flex align-items-center">
                Autori - se va completa la câmpul “Autori”
            </div>
        </div>
    </div>
</div>
@endif
<div class="row pt-4">
    <div class="col-lg-12 text-right">
        <button type="submit" class="btn btn-primary">Modifica</button>
    </div>
</div>
</form>
@endsection
