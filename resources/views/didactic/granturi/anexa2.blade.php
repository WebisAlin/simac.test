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
            <table class="table tabela3 table-bordered mt-2">
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
        </div>
        <div class="row paddingTop50">
            <div class="col-md-2 d-flex align-items-center">
                <h6 class="mb-0">Autori din eUT:</h6>
                <input type="checkbox" class="form-control" name="autori_din_strainatate">
            </div>
            <div class="col-md-10 text-right"></div>
        </div>
    </div>
</div>
