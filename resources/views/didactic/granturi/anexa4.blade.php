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
                                <th class="col-8"><input type="radio" class="form-control" value="1" name="tip_brevet">
                                </th>
                            </tr>
                            <tr>
                                <th class="col-4" style="vertical-align: middle;">Internationale:</th>
                                <th class="col-8"><input type="radio" class="form-control" value="2" name="tip_brevet">
                                </th>
                            </tr>
                            <tr>
                                <th class="col-4" style="vertical-align: middle;">Nationale:</th>
                                <th class="col-8"><input type="radio" class="form-control" value="3" name="tip_brevet">
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
                                        placeholder="Număr brevet" required></th>
                            </tr>
                            <tr>
                                <th class="col-2" style="vertical-align: middle;">Titlu brevet:</th>
                                <th class="col-10"><input type="text" class="form-control" name="titlu_brevet"
                                        placeholder="Titlu brevet" required></th>
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
            <table class="table tabela4 table-bordered mt-2">
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
                    </tr>
                </tbody>
            </table>
        </div>
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
        <table class="table tabela5 table-bordered mt-2">
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
                    <td><input type='checkbox' value='1' class='form-control' name='membra_din_afara_utcn[]'>
                    </td>
                </tr>
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
                </tr>
            </tbody>
        </table>
        <div class="row mt-5">
            <h6>Ataşez următoarele documente justificative:</h6>
            <div class="col-md-12 d-flex align-items-center">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="col-1" style="vertical-align: middle;">1. Dovada obținerii brevetului (copie
                                brevet)
                                <input type="file" class="form-control mt-4" name="dovada_brevet">
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
