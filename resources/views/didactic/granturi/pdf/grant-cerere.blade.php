<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cerere grant</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optbancanal theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ env('APP_URL') }}/assets/images/brand/favicon.png"
        type="image/x-icon">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>
    <style>
        .page-break {
            page-break-after: always;
        }
    
        body {
            font-size: 10px;
            color: #000000;
            background-image: url('<?=env('APP_URL')?>/assets/images/img_invoice_opacity.png');
            padding: 30px;
            background-size: cover;
            font-family: DejaVu Sans, sans-serif;
        }

        .tabela1 th,
        .tabela1 td {
            border: 1px solid #000;
            padding: 5px;
        }

        .tabela1 th {
            text-align: left;
        }

        .tabela1 input[type="checkbox"] {
            margin: 0;
            padding: 0;
            width: 16px;
            height: 16px;
            vertical-align: middle;
            position: relative;
            top: -1px;
            *overflow: hidden;
        }

        .checkbox-grup {
            margin-right: 5px;
            margin-left: 5px;
        }

        .tabela1 tr:hover {
            background-color: #f5f5f5;
        }

    </style>
</head>

<body>
    <div style="page-break-after: always;">
    <table width="100%">
        <tr>
            <td class="text-right" width="75%"></td>
            <td class="text-center" width="25%">
                <h6>
                    APROBAT <br>
                    RECTOR, <br>
                    Prof. Dr. ing. Vasile Topa <br>
                </h6>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center mt-4">
                <h6>CERERE<br>
                    de grant-suport conform HCA 135 / 15.12.2020 si de stimulare a publicarii în reviste indexate
                    <br>
                    Web of Science (ISI) cu factor de impact (FI) conform HCA 11 / 25.01.2023 si HCA 139 /
                    14.12.2021
                </h6>
            </td>
        </tr>
    </table>
    <table class="tabela1" width="100%" style="margin-top:30px;">
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
                        <?php ($grantCerere->id_anexa == 1?'checked':'') ?>></th>
                <th>Cerere de grant-suport pentru publicații științifice în reviste indexate Web of Science
                    (ISI) cu
                    factor de impact (FI)</th>
                <th>1 </th>
                <th>135 / 2020</th>
            </tr>
            <tr>
                <th scope="row"><input name="nr_anexa2" class="checkbox-grup" type="checkbox"
                        <?php ($grantCerere->id_anexa == 2?'checked':'') ?>></th>
                <th>Cerere de finanțare conform HCA Nr. 11 din 25.01.2023 (Art. 2.1.) / HCA Nr. 139 din
                    14.12.2021
                    (Art. 1.1.)</th>
                <th>2</th>
                <th>11/2023, 139/2021 </th>
            </tr>
            <tr>
                <th scope="row"><input name="nr_anexa3" class="checkbox-grup" type="checkbox"
                        <?php ($grantCerere->id_anexa == 3?'checked':'') ?>></th>
                <th>Cerere de finanțare conform HCA Nr. 11 din 25.01.2023 (Art. 2.2.) / HCA Nr. 139 din
                    14.12.2021
                    (Art. 1.2.) </th>
                <th>3</th>
                <th>11/2023, 139/2021</th>
            </tr>
            <tr>
                <th scope="row"><input name="nr_anexa4" class="checkbox-grup" type="checkbox"
                        <?php ($grantCerere->id_anexa == 4?'checked':'') ?>></th>
                <th>Cerere de grant-suport pentru Brevete</th>
                <th>4</th>
                <th>135 / 2020</th>
            </tr>
            <tr>
                <th scope="row"><input name="nr_anexa5" class="checkbox-grup" type="checkbox"
                        <?php ($grantCerere->id_anexa == 5?'checked':'') ?>></th>
                <th>Cerere de grant-suport pentru Citări</th>
                <th>5</th>
                <th>135 / 2020</th>
            </tr>
            <tr>
                <th scope="row"><input name="nr_anexa6" class="checkbox-grup" type="checkbox"
                        <?php ($grantCerere->id_anexa == 6?'checked':'') ?>></th>
                <th>Cerere de grant-suport pentru Premii ale Academiei Române sau ale unor Organizații
                    Internaționale</th>
                <th>6</th>
                <th>135 / 2020 </th>
            </tr>
        </tbody>
    </table>
    <table width="100%" style="margin-top:20px;">
        <tr>
            <td class="text-left" width="100%">
                <h6>Date de contact:</h6>
            </td>
        </tr>
    </table>
    <table class="tabela1" width="100%">
        <tbody>
            <tr>
                <th class="text-right" width="25%">Nume și Prenume:</th>
                <th width="75%">{{ $grantCerere->nume_grant }}</th>
            </tr>
            <tr>
                <th class="text-right" width="25%">Facultate:</th>
                <th width="75%">{{ $grantCerere->nume_facultate }}</th>
            </tr>
            <tr>
                <th class="text-right" width="25%">Departament:</th>
                <th width="75%">{{ $grantCerere->nume_departament }}</th>
            </tr>
            <tr>
                <th class="text-right" width="25%">Telefon la birou:</th>
                <th width="75%">{{ $grantCerere->telefon_birou_grant }}</th>
            </tr>
        </tbody>
    </table>
    <table width="100%" style="margin-top:10px;">
        <tbody>
            <tr>
                <th width="15%">Telefon mobil:</th>
                <th width="35%">{{ $grantCerere->telefon_grant }}</th>
                <th width="10%">E-mail:</th>
                <th width="40%">{{ $grantCerere->email_grant }}</th>
            </tr>
        </tbody>
    </table>
    <table class="tabela1" width="100%" style="margin-top:30px;">
        <tbody>
            <tr>
                <th width="100%">Numai pentru doctoranzi:</th>
            </tr>
        </tbody>
    </table>
    <table class="tabela1" width="100%">
        <tbody>
            <tr>
                <th class="text-right" width="25%">Nume și Prenume:</th>
                <th width="75%">{{ $grantCerere->nume_doctorand_grant }}</th>
            </tr>
            <tr>
                <th class="text-right" width="25%">Doctorand din anul:</th>
                <th width="75%">{{ $grantCerere->an_doctorand_grant }}</th>
            </tr>
            <tr>
                <th class="text-right" width="25%">Conducător de doctorat: </th>
                <th width="75%">(grad didactic, nume,
                    prenume) {{ $grantCerere->conducator_doctorand_grant }}</th>
            </tr>
        </tbody>
    </table>
    <table width="100%" style="margin-top:20px;">
        <tbody>
            <tr>
                <th class="text-left" width="100%">Data: {{ $grantCerere->data_grant }}</th>
            </tr>
        </tbody>
    </table>
    <table width="100%" style="margin-top:10px;">
        <tbody>
            <tr>
                <th class="text-left" width="50%">Semnătura autor solicitant, <br> <img style="margin-top:5px"
                        src="{{ env('APP_URL') }}/public/uploads/semnatura_cd/small/{{ $grantCerere->semnatura_grant }}"
                        height="50"></th>
                <th width="50%">Verificat DMCDI,</th>
            </tr>
        </tbody>
    </table>
    <table width="100%" style="margin-top:50px;">
        <tbody>
            <tr>
                <th class="text-left" width="100%"> Cererea se completează obligatoriu ELECTRONIC împreună cu anexele
                    selectate, după care se listează.
                    Cererea se completează pentru o singură lucrare ISI. Mai multe lucrări fac obiectul mai multor
                    cereri.
                    Cererea se depune prin registratură, către Z-CERCET-Granturi.
                    Vă rugăm NU modificați structura și formatul documentului!
                    Pentru fiecare lucrare, brevet se va face solicitarea de către unul din autori.
                    Se vor trece obligatoriu datele de contact ale autorului solicitant
                </th>
            </tr>
        </tbody>
    </table>
    </div>
    @if($grantCerere->anexa1)
    <!-- anexa 1  -->
    <div style="page-break-after: always;">
    <table width="100%">
        <tr>
            <td class="text-right" width="75%"></td>
            <td class="text-center" width="25%">
                <h6>
                    Anexa 1
                </h6>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center mt-4">
                <h6>CERERE<br>
                        de grant-suport pentru publicatii stiintifice în reviste indexate <br>
                        Web of Science (ISI) cu factor de impact (FI)
                    <br>
                </h6>
            </td>
        </tr>
    </table>
    <table style="margin-top:30px;" width="100%">
        <tbody>
            <tr>
                <th style="text-align:left;" width="15%">Autori din UTCN: </th>
                <th width="85%">{{$grantCerere->anexa1->autori_utcn}}</th>
            </tr>
        </tbody>
    </table>
    @if (!empty($grantCerere->anexa1->lista_autori_utcn))
    @php
        $autori = json_decode($grantCerere->anexa1->lista_autori_utcn, true);
    @endphp
        <table class="tabela1" width="100%">
            <thead>
                <tr>
                    <th width="5%">Nr. crt.</th>
                    <th width="20%" style="text-align:center;">Numele</th>
                    <th width="20%" style="text-align:center;">Prenumele</th>
                    <th width="20%" style="text-align:center;">Funcţia (Prof/Conf/Sl/Lect/Asist/Drd)</th>
                    <th width="20%" style="text-align:center;">Facultate / Departament</th>
                    <th width="15%" style="text-align:center;">Semnatura autori</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($autori as $index => $autor)
                    <tr>
                        <td width="5%">{{ $index + 1 }}</td>
                        <td width="20%">{{ $autor['nume'] }}</td>
                        <td width="20%">{{ $autor['prenume'] }}</td>
                        <td width="20%">{{ $autor['functia'] }}</td>
                        <td width="20%">{{ $autor['facultate'] }}</td>
                        <td width="15%">
                            @if ($autor['semnatura'])
                            <img style="margin-top:5px" src="{{env('APP_URL') }}/public/uploads/anexa1/{{$autor['semnatura']}}" height="30">
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <table style="margin-top:30px;" width="100%">
        <tbody>
            <tr>
                <th class="text-left" width="100%">
                Autori din afara UTCN: {{$grantCerere->anexa1->autori_din_afara_utcn}}
                ,Autori din străinătate:
                @if ($grantCerere->anexa1->autori_din_strainatate == 0)
                    <input type='checkbox' >
                @else
                    <input type='checkbox' checked>
                @endif
                </th>
            </tr>
        </tbody>
    </table>
    @if (!empty($grantCerere->anexa1->lista_autori_din_afara_utcn))
    @php
        $autori = json_decode($grantCerere->anexa1->lista_autori_din_afara_utcn, true);
    @endphp
        <table class="tabela1" width="100%">
            <thead>
                <tr>
                    <th width="5%">Nr. crt.</th>
                    <th width="20%" style="text-align:center;">Numele</th>
                    <th width="20%" style="text-align:center;">Prenumele</th>
                    <th width="20%" style="text-align:center;">Funcţia (Prof/Conf/Sl/Lect/Asist/Drd)</th>
                    <th width="20%" style="text-align:center;">Afiliere</th>
                    <th width="15%" style="text-align:center;">Membră eUT+</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($autori as $index => $autor)
                    <tr>
                        <td width="5%">{{ $index + 1 }}</td>
                        <td width="20%">{{ $autor['nume'] }}</td>
                        <td width="20%">{{ $autor['prenume'] }}</td>
                        <td width="20%">{{ $autor['functia'] }}</td>
                        <td width="20%">{{ $autor['afiliere'] }}</td>
                        <td width="15%">
                            @if ($autor['membra'] == 0)
                                <input type='checkbox' >
                            @else
                                <input type='checkbox' checked>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <table width="100%">
        <tbody>
            <tr>
                <th style="text-align:left;" width="10%">Total Autori:  </th>
                <th width="90%">{{$grantCerere->anexa1->total_autori}}</th>
            </tr>
        </tbody>
    </table>
    <table width="100%" style="margin-top:40px;">
        <tbody>
            <tr>
                <th width="16%">Articol şi revista: <br>
                    Tipul publicației : </th>
                <th width="5%"></th>
                <th width="44%">
                    <table class="tabela1" width="100%">
                        <tbody>
                            <tr>
                                <th class="text-right" width="90%">ISI Q1 – Top 5% sau în primele 3   poziții (cf. JCR category)</th>
                                <th width="10%"><input type="checkbox" <?php ($grantCerere->anexa1->tip_publicatie == 1?'checked':'') ?>></th>
                            </tr>
                            <tr>
                                <th class="text-right" width="90%">ISI Q1</th>
                                <th width="10%"><input type="checkbox" <?php ($grantCerere->anexa1->tip_publicatie == 2?'checked':'') ?>></th>
                            </tr>
                            <tr>
                                <th class="text-right" width="90%">ISI Q2</th>
                                <th width="10%"><input type="checkbox" <?php ($grantCerere->anexa1->tip_publicatie == 3?'checked':'') ?>></th>
                            </tr>
                            <tr>
                                <th class="text-right" width="90%">ISI – Arts & Humanities</th>
                                <th width="10%"><input type="checkbox" <?php ($grantCerere->anexa1->tip_publicatie == 4?'checked':'') ?>></th>
                            </tr>
                            <tr>
                                <th class="text-right" width="90%">Erih Plus</th>
                                <th width="10%"><input type="checkbox" <?php ($grantCerere->anexa1->tip_publicatie == 5?'checked':'') ?>></th>
                            </tr>
                            <tr>
                                <th class="text-right" width="90%">Nature</th>
                                <th width="10%"><input type="checkbox" <?php ($grantCerere->anexa1->tip_publicatie == 6?'checked':'') ?>></th>
                            </tr>
                            <tr>
                                <th class="text-right" width="90%">Monografii</th>
                                <th width="10%"><input type="checkbox" <?php ($grantCerere->anexa1->tip_publicatie == 7?'checked':'') ?>></th>
                            </tr>
                        </tbody>
                    </table>
                </th>
                <th width="5%">
                </th>
                <th width="30%">
                    <table class="tabela1" width="100%">
                        <tbody>
                            <tr>
                                <th class="text-right" width="90%">Open Access</th>
                                <th width="10%"><input type="checkbox" <?php ($grantCerere->anexa1->open_access == 1?'checked':'') ?>></th>
                            </tr>
                        </tbody>
                    </table>
                </th>
            </tr>
        </tbody>
    </table>
    <table class="tabela1" width="100%" style="margin-top:40px;">
        <tbody>
            <tr>
                <th width="30%">Detalii publicare: </th>
                <th width="70%">{{$grantCerere->anexa1->detalii_publicare}}</th>
            </tr>
            <tr>
                <th width="30%">Titlul lucrării: </th>
                <th width="70%">{{$grantCerere->anexa1->titlul_lucrarii}}</th>
            </tr>
        </tbody>
    </table>
    <table class="tabela1" width="100%" style="margin-top:10px;">
        <tbody>
            <tr>
                <th width="30%">Denumirea revistei:</th>
                <th width="70%">{{$grantCerere->anexa1->denumirea_revistei}}</th>
            </tr>
        </tbody>
    </table>
    <table class="tabela1" width="100%" style="margin-top:10px;">
        <tbody>
            <tr>
                <th width="5%">Vol:</th>
                <th width="5%">{{$grantCerere->anexa1->vol}}</th>
                <th width="5%">Nr:</th>
                <th width="5%">{{$grantCerere->anexa1->nr}}</th>
                <th width="5%">An*:</th>
                <th width="5%">{{$grantCerere->anexa1->an}}</th>

                <th width="10%">Luna</th>
                <th width="10%">{{$grantCerere->anexa1->luna}}</th>
                <th width="15%">Pag încep:</th>
                <th width="10%">{{$grantCerere->anexa1->pag_incep}}</th>
                <th width="15%">Pag sfârşit:</th>
                <th width="10%">{{$grantCerere->anexa1->pag_sfarsit}}</th>
            </tr>
        </tbody>
    </table>
    <table width="100%">
        <tbody>
            <tr>
                <th width="100%">*Anul publicării nu apariției de tip Early Access</th>
            </tr>
        </tbody>
    </table>
    <table class="tabela1" width="100%" style="margin-top:40px;">
        <tbody>
            <tr>
                <th width="30%">ISSN/ISBN: </th>
                <th width="70%">{{$grantCerere->anexa1->issn_isbn}}</th>
            </tr>
            <tr>
                <th width="30%">DOI sau WOS:  </th>
                <th width="70%">{{$grantCerere->anexa1->doi_wos}}</th>
            </tr>
            <tr>
                <th width="90%">Factor de impact în anul anterior publicării: </th>
                <th width="10%">{{$grantCerere->anexa1->factor_impact}}</th>
            </tr>
        </tbody>
    </table>
    <table width="100%" style="margin-top:20px;">
        <tbody>
            <tr>
                <th width="100%">Atașez următoarele documente justificative:</th>
            </tr>
        </tbody>
    </table>
    <table class="tabela1" class="tabela1" width="100%" style="margin-top:10px;">
        <tbody>
            <tr>
                <th width="100%">1. Dovada publicării și indexării în Web of Science cu specificarea zonei de încadrare</th>
            </tr>
            <tr>
                <th width="100%"><a href="{{env('APP_URL')}}/public/uploads/anexa1/{{$grantCerere->anexa1->dovada_publicarii}}" target="_blank">Download</a></th>
            </tr>
        </tbody>
    </table>
    <table class="tabela1" class="tabela1" width="100%" style="margin-top:10px;">
        <tbody>
            <tr>
                <th width="100%">2. Copie articol publicat</th>
            </tr>
            <tr>
                <th width="100%"><a href="{{env('APP_URL')}}/public/uploads/anexa1/{{$grantCerere->anexa1->copie_articol}}" target="_blank">Download</a></th>
            </tr>
        </tbody>
    </table>
    </div>
   @endif
   @if($grantCerere->anexa2)
     <!-- anexa 2  -->
     <div style="page-break-after: always;">
     <table width="100%">
        <tr>
            <td class="text-right" width="75%"></td>
            <td class="text-center" width="25%">
                <h6>
                    Anexa 2
                </h6>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center mt-4">
                <h6>CERERE<br>
                    de finantare conform HCA Nr. 11 din 25.01.2023 (Art.2.1.) <br>
                    (aceasta anexa se completeaza impreuna cu Anexa 1)
                    <br>
                </h6>
            </td>
        </tr>
    </table>
    <table style="margin-top:30px;" width="100%">
        <tbody>
            <tr>
                <th style="text-align:left;" width="15%">Autori din UTCN: </th>
                <th width="85%">{{$grantCerere->anexa2->autori_utcn}}</th>
            </tr>
        </tbody>
    </table>
    @if (!empty($grantCerere->anexa2->lista_autori_utcn))
    @php
        $autori = json_decode($grantCerere->anexa2->lista_autori_utcn, true);
    @endphp
        <table class="tabela1" width="100%">
            <thead>
                <tr>
                    <th width="5%">Nr. crt.</th>
                    <th width="20%" style="text-align:center;">Numele</th>
                    <th width="20%" style="text-align:center;">Prenumele</th>
                    <th width="20%" style="text-align:center;">Funcţia (Prof/Conf/Sl/Lect/Asist/Drd)</th>
                    <th width="20%" style="text-align:center;">Facultate / Departament</th>
                    <th width="15%" style="text-align:center;">Semnatura autori</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($autori as $index => $autor)
                    <tr>
                        <td width="5%">{{ $index + 1 }}</td>
                        <td width="20%">{{ $autor['nume'] }}</td>
                        <td width="20%">{{ $autor['prenume'] }}</td>
                        <td width="20%">{{ $autor['functia'] }}</td>
                        <td width="20%">{{ $autor['facultate'] }}</td>
                        <td width="15%">
                            @if ($autor['semnatura'])
                            <img style="margin-top:5px;" src="{{env('APP_URL') }}/public/uploads/anexa2/{{$autor['semnatura']}}" height="30">
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <table style="margin-top:30px;" width="100%">
        <tbody>
            <tr>
                <th class="text-left" width="100%">
                Autori din eUT+ [<input type='checkbox' >/<input type='checkbox' checked>]: 
                @if ($grantCerere->anexa2->autori_din_eUT == 0)
                    <input type='checkbox' >
                @else
                    <input type='checkbox' checked>
                @endif
                </th>
            </tr>
        </tbody>
    </table>
     </div>
@endif
@if($grantCerere->anexa3)
     <!-- anexa 3  -->
    <div style="page-break-after: always;">
    <table width="100%">
        <tr>
            <td class="text-right" width="75%"></td>
            <td class="text-center" width="25%">
                <h6>
                    Anexa 3
                </h6>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center mt-4">
                <h6>CERERE<br>
                    de finanțare conform HCA Nr. 11 din 25.01.2023 (Art.2.2.) <br>
                    (aceasta anexa se completeaza impreuna cu Anexa 1)
                    <br>
                </h6>
            </td>
        </tr>
    </table>
    <table style="margin-top:30px;" width="100%">
        <tbody>
            <tr>
                <th class="text-left" width="100%">
                Date propunere:
                </th>
            </tr>
        </tbody>
    </table>
    <table class="tabela1" width="100%">
        <tbody>
            <tr>
                <th class="text-right" width="25%">Finanțator:</th>
                <th width="75%">{{$grantCerere->anexa3->finantator}}</th>
            </tr>
            <tr>
                <th class="text-right" width="25%">Program:</th>
                <th width="75%">{{$grantCerere->anexa3->program}}</th>
            </tr>
            <tr>
                <th class="text-right" width="25%">An competiție:</th>
                <th width="75%">{{$grantCerere->anexa3->an_competitie}}</th>
            </tr>
            <tr>
                <th class="text-right" width="25%">Titlu propunere proiect:</th>
                <th width="75%">{{$grantCerere->anexa3->titlu_propunere}}</th>
            </tr>
            <tr>
                <th class="text-right" width="25%">Cod propunere:</th>
                <th width="75%">{{$grantCerere->anexa3->cod_propunere}}</th>
            </tr>
            <tr>
                <th class="text-right" width="25%">Calitate în propunere [coordonator/responsabil partener*]:</th>
                <th width="75%">{{$grantCerere->anexa3->calitate_propunere}}</th>
            </tr>
            <tr>
                <th class="text-right" width="25%">Punctaj obținut**:</th>
                <th width="75%">{{$grantCerere->anexa3->punctaj_obtinut}}</th>
            </tr>
            <tr>
                <th class="text-right" width="25%">Punctaj maxim competiție**:</th>
                <th width="75%">{{$grantCerere->anexa3->punctaj_maxim_competitie}}</th>
            </tr>
            <tr>
                <th class="text-right" width="25%">Procent [%]:</th>
                <th width="75%">{{$grantCerere->anexa3->procent}}</th>
            </tr>
        </tbody>
    </table>
    <table width="100%">
        <tbody>
            <tr>
                <th class="text-left" width="100%">
                * Doar in cazul competițiilor Horizon <br>
                ** Se anexează dovezile (fișa de evaluare, link spre rezultate publice, extras din pachet informații sau alte documente din care să rezulte punctajul obținut, respectiv punctajul maxim al competiției, și data limită de depunere a propunerilor).
                </th>
            </tr>
        </tbody>
    </table>
    <table style="margin-top:30px;" width="100%">
        <tbody>
            <tr>
                <th class="text-left" width="100%">
                Parteneri din eUT+ [<input type='checkbox' >/<input type='checkbox' checked>]: 
                @if ($grantCerere->anexa3->parteneri_eut == 0)
                    <input type='checkbox' >
                @else
                    <input type='checkbox' checked>
                @endif
                </th>
            </tr>
        </tbody>
    </table>
    </div>
    @endif
    <!-- anexa 4 -->
    @if($grantCerere->anexa4)
    <div style="page-break-after: always;">
    <table width="100%">
        <tr>
            <td class="text-right" width="75%"></td>
            <td class="text-center" width="25%">
                <h6>
                    Anexa 4
                </h6>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center mt-4">
                <h6>CERERE<br>
                    de grant-suport pentru Brevete <br>
                </h6>
            </td>
        </tr>
    </table>
    <table width="100%" style="margin-top:40px;">
        <tbody>
            <tr>
                <th width="30%">Tip brevet :</th>
                <th width="22%">
                    <table class="tabela1" width="100%">
                        <tbody>
                            <tr>
                                <th class="text-right" width="25%">Triadice</th>
                                <th width="75%"><input type="checkbox" <?php ($grantCerere->anexa4->tip_brevet == 1?'checked':'') ?>></th>
                            </tr>
                            <tr>
                                <th class="text-right" width="25%">Internationale:</th>
                                <th width="75%"><input type="checkbox" <?php ($grantCerere->anexa4->tip_brevet == 2?'checked':'') ?>></th>
                            </tr>
                            <tr>
                                <th class="text-right" width="25%">Nationale: </th>
                                <th width="75%"><input type="checkbox" <?php ($grantCerere->anexa4->tip_brevet == 3?'checked':'') ?>></th>
                            </tr>
                        </tbody>
                    </table>
                </th>
                <th width="68%"></th>
            </tr>
        </tbody>
    </table>
    <table class="tabela1" style="margin-top:30px;" width="100%">
        <tbody>
            <tr>
                <th class="text-right" width="25%">Număr brevet</th>
                <th width="75%">{{$grantCerere->anexa4->numar_brevet}}</th>
            </tr>
            <tr>
                <th class="text-right" width="25%">Titlu brevet:</th>
                <th width="75%">{{$grantCerere->anexa4->titlu_brevet}}</th>
            </tr>
        </tbody>
    </table>
    <table style="margin-top:30px;" width="100%">
        <tbody>
            <tr>
                <th style="text-align:left;" width="15%">Autori din UTCN: </th>
                <th width="85%">{{$grantCerere->anexa4->autori_utcn}}</th>
            </tr>
        </tbody>
    </table>
    @if (!empty($grantCerere->anexa4->lista_autori_utcn))
    @php
        $autori = json_decode($grantCerere->anexa4->lista_autori_utcn, true);
    @endphp
        <table class="tabela1" width="100%">
            <thead>
                <tr>
                    <th width="5%">Nr. crt.</th>
                    <th width="20%" style="text-align:center;">Numele</th>
                    <th width="20%" style="text-align:center;">Prenumele</th>
                    <th width="20%" style="text-align:center;">Funcţia (Prof/Conf/Sl/Lect/Asist/Drd)</th>
                    <th width="20%" style="text-align:center;">Facultate / Departament</th>
                    <th width="15%" style="text-align:center;">Semnatura autori</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($autori as $index => $autor)
                    <tr>
                        <td width="5%">{{ $index + 1 }}</td>
                        <td width="20%">{{ $autor['nume'] }}</td>
                        <td width="20%">{{ $autor['prenume'] }}</td>
                        <td width="20%">{{ $autor['functia'] }}</td>
                        <td width="20%">{{ $autor['facultate'] }}</td>
                        <td width="15%">
                            @if ($autor['semnatura'])
                            <img style="margin-top:5px" src="{{env('APP_URL') }}/public/uploads/anexa4/{{$autor['semnatura']}}" height="30">
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <table style="margin-top:30px;" width="100%">
        <tbody>
            <tr>
                <th style="text-align:left;" width="20%">Autori din afara UTCN: </th>
                <th width="80%">{{$grantCerere->anexa4->autori_din_afara_utcn}}</th>
            </tr>
        </tbody>
    </table>
    @if (!empty($grantCerere->anexa4->lista_autori_din_afara_utcn))
    @php
        $autori = json_decode($grantCerere->anexa4->lista_autori_din_afara_utcn, true);
    @endphp
        <table class="tabela1" width="100%">
            <thead>
                <tr>
                    <th width="5%">Nr. crt.</th>
                    <th width="20%" style="text-align:center;">Numele</th>
                    <th width="20%" style="text-align:center;">Prenumele</th>
                    <th width="20%" style="text-align:center;">Funcţia (Prof/Conf/Sl/Lect/Asist/Drd)</th>
                    <th width="20%" style="text-align:center;">Afiliere</th>
                    <th width="15%" style="text-align:center;">Membră eUT+</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($autori as $index => $autor)
                    <tr>
                        <td width="5%">{{ $index + 1 }}</td>
                        <td width="20%">{{ $autor['nume'] }}</td>
                        <td width="20%">{{ $autor['prenume'] }}</td>
                        <td width="20%">{{ $autor['functia'] }}</td>
                        <td width="20%">{{ $autor['afiliere'] }}</td>
                        <td width="15%">
                            @if ($autor['membra'] == 0)
                                <input type='checkbox' >
                            @else
                                <input type='checkbox' checked>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <table width="100%">
        <tbody>
            <tr>
                <th style="text-align:left;" width="15%">Total Autori:  </th>
                <th width="85%">{{$grantCerere->anexa4->total_autori}}</th>
            </tr>
        </tbody>
    </table>
    <table width="100%" style="margin-top:40px;">
        <tbody>
            <tr>
                <th width="100%">Atașez următoarele documente justificative:</th>
            </tr>
        </tbody>
    </table>
    <table class="tabela1" width="100%">
        <tbody>
            <tr>
                <th width="100%">1. Dovada obținerii brevetului (copie brevet) </th>
            </tr>
            <tr>
                <th width="100%"><a href="{{env('APP_URL')}}/public/uploads/anexa4/{{$grantCerere->anexa4->dovada_brevet}}" target="_blank">Download</a></th>
            </tr>
        </tbody>
    </table>
    </div>
    @endif
    <!-- anexa 5 -->
    @if($grantCerere->anexa5)
    <div style="page-break-after: always;">
    <table width="100%">
        <tr>
            <td class="text-right" width="75%"></td>
            <td class="text-center" width="25%">
                <h6>
                    Anexa 5
                </h6>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center mt-4">
                <h6>CERERE<br>
                de grant-suport pentru Citari <br>
                </h6>
            </td>
        </tr>
    </table>
    <table class="tabela1" width="100%" style="margin-top:40px;">
        <tbody>
            <tr>
                <th width="80%">Citări independente în publicații indexate Web of Science obținute în an anterior (n) </th>
                <th width="20%">{{$grantCerere->anexa5->an_anterior}}</th>
            </tr>
        </tbody>
    </table>
    <table class="tabela1" width="100%">
        <tbody>
            <tr>
                <th width="80%">Citări independente în publicații indexate Web of Science obținute în anul precedent anului anterior (n-1) </th>
                <th width="20%">{{$grantCerere->anexa5->an_precedent}}</th>
            </tr>
        </tbody>
    </table>
    <table width="100%" style="margin-top:40px;">
        <tbody>
            <tr>
                <th width="100%">Atașez următoarele documente justificative:</th>
            </tr>
        </tbody>
    </table>
    <table class="tabela1" width="100%">
        <tbody>
            <tr>
                <th width="100%">Dovada citărilor independente din Web of Science – print screen după citation report </th>
            </tr>
            <tr>
                <th width="100%"><a href="{{env('APP_URL')}}/public/uploads/anexa5/{{$grantCerere->anexa5->dovada_citari}}" target="_blank">Download</a></th>
            </tr>
        </tbody>
    </table>
    </div>
    @endif
<!-- anexa 6 -->
    @if($grantCerere->anexa6)
    <table width="100%">
        <tr>
            <td class="text-right" width="75%"></td>
            <td class="text-center" width="25%">
                <h6>
                    Anexa 6
                </h6>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center mt-4">
                <h6>CERERE<br>
                de grant-suport pentru <br>
                Premii ale Academiei Române sau ale unor Organizatii Internationale
                </h6>
            </td>
        </tr>
    </table>
    <table width="100%" style="margin-top:40px;">
        <tbody>
            <tr>
                <th width="50%">Premiul  Academiei Române pentru anul </th>
                <th width="10%">{{$grantCerere->anexa6->an_premiu}}</th>
                <th width="20%">decernat in anul <th>
                <th width="30%">{{$grantCerere->anexa6->an_decernat}}</th>
            </tr>
        </tbody>
    </table>
    <table width="100%" style="margin-top:10px;">
        <tbody>
            <tr>
                <th width="15%">Domeniu  </th>
                <th width="85%">{{$grantCerere->anexa6->domeniu}}</th>
            </tr>
        </tbody>
    </table>
    <table width="100%" style="margin-top:10px;">
        <tbody>
            <tr>
                <th width="15%">Premiu  </th>
                <th width="85%">{{$grantCerere->anexa6->premiu}}</th>
            </tr>
        </tbody>
    </table>
    <table width="100%" style="margin-top:10px;">
        <tbody>
            <tr>
                <th width="15%">Titlul lucrării  </th>
                <th width="85%">{{$grantCerere->anexa6->titlu_lucrare}}</th>
            </tr>
        </tbody>
    </table>
    <table width="100%" style="margin-top:20px;">
        <tbody>
            <tr>
                <th width="100%">Autori - se va completa la câmpul “Autori”  </th>
            </tr>
        </tbody>
    </table>
    @endif
</body>
</html>
