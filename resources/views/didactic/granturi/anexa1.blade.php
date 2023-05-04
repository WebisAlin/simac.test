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
            <table class="table tabela1 table-bordered mt-2">
                <thead>
                    <tr>
                        <th>Nr. crt.</th>
                        <th>Numele</th>
                        <th>Prenumele</th>
                        <th>Funcţia (Prof/Conf/Sl/Lect/Asist/Drd)</th>
                        <th>Facultate / Departament</th>
                        <th>Semnatura autori</th>
                    </tr>
                </thead>
                <tbody>
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
        <table class="table tabela2 table-bordered mt-2">
            <thead>
                <tr>
                    <th>Nr. crt.</th>
                    <th>Numele</th>
                    <th>Prenumele</th>
                    <th>Funcţia (Prof/Conf/Sl/Lect/Asist/Drd)</th>
                    <th>Facultate / Departament</th>
                    <th>MembrăeUT+</th>
                </tr>
            </thead>
            <tbody>
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
                    <td><input type='checkbox' value='' class='form-control' name='membra_din_afara_utcn[]'></td>
                </tr>
            </tbody>
        </table>
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
                            <th class="col-1 "><input name="tip_publicatie" type="checkbox" value="1"></th>
                        </tr>
                        <tr>
                            <th class="col-11" style="vertical-align: middle;">ISI Q1</th>
                            <th class="col-1"><input name="tip_publicatie" type="checkbox" value="2"></th>
                        </tr>
                        <tr>
                            <th class="col-11" style="vertical-align: middle;">ISI Q2</th>
                            <th class="col-1"><input name="tip_publicatie" type="checkbox" value="3"></th>
                        </tr>
                        <tr>
                            <th class="col-11" style="vertical-align: middle;">ISI – Arts & Humanities</th>
                            <th class="col-1"><input name="tip_publicatie" type="checkbox" value="4"></th>
                        </tr>
                        <tr>
                            <th class="col-11" style="vertical-align: middle;">Erih Plus</th>
                            <th class="col-1"><input name="tip_publicatie" type="checkbox" value="5"></th>
                        </tr>
                        <tr>
                            <th class="col-11" style="vertical-align: middle;">Nature</th>
                            <th class="col-1"><input name="tip_publicatie" type="checkbox" value="6"></th>
                        </tr>
                        <tr>
                            <th class="col-11" style="vertical-align: middle;">Monografii</th>
                            <th class="col-1"><input name="tip_publicatie" type="checkbox" value="7"></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="col-11" style="vertical-align: middle;">Open Access</th>
                            <th class="col-1"><input name="open_access" type="checkbox" value="8"></th>
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
                <input type="text" class="form-control" name="detalii_publicare" placeholder="Detalii publicare"
                    required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 d-flex align-items-center">
                <h6 class="mb-0">Titlul lucrării:</h6>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" name="titlul_lucrarii" placeholder="Titlul lucrării" required>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-2 d-flex align-items-center">
                <h6 class="mb-0">Denumirea revistei:</h6>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" name="denumirea_revistei" placeholder="Denumirea revistei"
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
                                    name="vol" placeholder="Vol" required>
                            </th>
                            <th class="col-1 " style="vertical-align: middle;">Nr:</th>
                            <th class="col-1" style="vertical-align: middle;"><input type="number" class="form-control"
                                    name="nr" placeholder="Nr" required>
                            </th>
                            <th class="col-1 " style="vertical-align: middle;">An:</th>
                            <th class="col-1" style="vertical-align: middle;"><input type="number" class="form-control"
                                    name="an" placeholder="An" required></th>
                            <th class="col-1 " style="vertical-align: middle;">Luna</th>
                            <th class="col-1" style="vertical-align: middle;"><input type="number" class="form-control"
                                    name="luna" placeholder="Luna" required></th>
                            <th class="col-1 " style="vertical-align: middle;">Pag încep:</th>
                            <th class="col-1" style="vertical-align: middle;"><input type="text" class="form-control"
                                    name="pag_incep" placeholder="Pag încep" required>
                            </th>
                            <th class="col-1 " style="vertical-align: middle;">Pag sfârşit:</th>
                            <th class="col-1" style="vertical-align: middle;"><input type="text" class="form-control"
                                    name="pag_sfarsit" placeholder="Pag sfârşit" required>
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
                <input type="text" class="form-control" name="issn_isbn" placeholder="ISSN/ISBN" required>
                <input type="text" class="form-control" name="doi_wos" placeholder="DOI sau WOS" required>
            </div>
            <div class="col-md-3 d-flex align-items-center">
                <h6 class="mb-0">Factor de impact în anul anterior publicării</h6>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control mt-4" name="factor_impact" required>
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
                                <input type="file" class="form-control mt-4" name="dovada_publicarii">
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12 d-flex align-items-center">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="col-1" style="vertical-align: middle;">2. Copie articol publicat
                                <input type="file" class="form-control mt-4" name="copie_articol">
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
