    $(document).ready(function(){
        // stergere elemente
        $('body').on('click', '.stergere', function(e) {
            tip=$(this).data("tip");
            id=$(this).data("id");
            nume=$(this).data("nume");
            switch(tip){
                case "utilizator":
                    titlu="Stergere utilizator";
                    text="Esti sigur ca vrei sa stergi utilizatorul '"+nume+"'?";
                    confirmare="Utilizator sters!";
                    esuare="Utilizatorul NU a fost sters!";
                    url = "/admin/utilizatori/" + id;
                break;
                case "limba":
                    titlu="Stergere limba";
                    text="Esti sigur ca vrei sa stergi limba '"+nume+"'?";
                    confirmare="Limba stearsa!";
                    esuare="Limba NU a fost stearsa!";
                    url = "/admin/limbi/" + id;
                break;
                case "pagina":
                    titlu="Stergere pagina";
                    text="Esti sigur ca vrei sa stergi pagina '"+nume+"'? Atentie! Se vor sterge toate versiunile paginii acesteia";
                    confirmare="Pagina stearsa!";
                    esuare="Pagina NU a fost stearsa!";
                    url = "/admin/pagini/" + id;
                break;
                case "rol":
                    titlu="Stergere rol";
                    text="Esti sigur ca vrei sa stergi rolul '"+nume+"'?";
                    confirmare="Rol sters!";
                    esuare="Rolul NU a fost sters!";
                    url = "/admin/roluri/" + id;
                break;
                case "departament":
                    titlu="Stergere departament";
                    text="Esti sigur ca vrei sa stergi departamentul '"+nume+"'?";
                    confirmare="Departament sters!";
                    esuare="Departamentul NU a fost sters!";
                    url = "/admin/departamente/" + id;
                break;
                case "facultate":
                    titlu="Stergere facultate";
                    text="Esti sigur ca vrei sa stergi facultatea '"+nume+"'?";
                    confirmare="Facultate stearsa!";
                    esuare="Facultatea NU a fost stearsa!";
                    url = "/admin/facultati/" + id;
                break;
                case "universitate":
                    titlu="Stergere universitate";
                    text="Esti sigur ca vrei sa stergi universitatea '"+nume+"'?";
                    confirmare="Universitate stearsa!";
                    esuare="Universitatea NU a fost stearsa!";
                    url = "/admin/universitati/" + id;
                break;
                case "didactic":
                    titlu="Stergere cadru didactic";
                    text="Esti sigur ca vrei sa stergi cadrul didactic '"+nume+"'?";
                    confirmare="Cadru didactic sters!";
                    esuare="Cadrul didactic NU a fost sters!";
                    url = "/admin/cadre-didactice/" + id;
                break;

                case "meniu":
                    titlu="Stergere meniu";
                    text="Esti sigur ca vrei sa stergi meniul '"+nume+"'?";
                    confirmare="Meniu sters!";
                    esuare="Meniul NU a fost sters!";
                    url = "/admin/meniuri/" + id;
                break;
                case "element_meniu":
                    titlu="Stergere element";
                    text="Esti sigur ca vrei sa stergi elementul '"+nume+"'?";
                    confirmare="Element meniu sters!";
                    esuare="Elementul din meniu NU a fost sters!";
                    url = "/admin/elemente-meniu/" + id;
                break;
                case "functie":
                    titlu="Stergere functie";
                    text="Esti sigur ca vrei sa stergi functia '"+nume+"'?";
                    confirmare="Functia stearsa!";
                    esuare="Functia NU a fost stearsa!";
                    url = "/admin/functii/" + id;
                break;
                case "valutar":
                    titlu="Stergere curs valutar";
                    text="Esti sigur ca vrei sa stergi cursul valutar cu id-ul '"+nume+"'?";
                    confirmare="Curs valutar sters!";
                    esuare="Cursul valutar NU a fost sters!";
                    url = "/admin/cursuri-valutare/" + id;
                case "proiect":
                    titlu="Stergere proiect";
                    text="Esti sigur ca vrei sa stergi proiectul '"+nume+"'?";
                    confirmare="Proiect sters!";
                    esuare="Proiectul NU a fost sters!";
                    url = "/admin/proiecte/" + id;
                break;
                case "proiect_membru":
                    titlu="Stergere membru proiect";
                    text="Esti sigur ca vrei sa stergi membrul '"+nume+"'?";
                    confirmare="Membru sters!";
                    esuare="Membrul NU a fost sters!";
                    url = "/admin/proiecte-membri/" + id;
                break;
                case "proiect_entitate":
                    titlu="Stergere entitate proiect";
                    text="Esti sigur ca vrei sa stergi entitatea '"+nume+"'?";
                    confirmare="Entitate stearsa!";
                    esuare="Entitatea NU a fost stearsa!";
                    url = "/admin/proiecte-entitati/" + id;
                break;
                case "proiect_tip":
                    titlu="Stergere tip proiect";
                    text="Esti sigur ca vrei sa stergi tipul de proiect '"+nume+"'?";
                    confirmare="Tip de proiect sters!";
                    esuare="Tipul de proiect NU a fost sters!";
                    url = "/admin/tipuri-proiecte/" + id;
                break;
                case "proiect_notificare":
                    titlu="Stergere notificare proiect";
                    text="Esti sigur ca vrei sa stergi notificarea '"+nume+"'?";
                    confirmare="Notificarea stearsa!";
                    esuare="Notificarea NU a fost stearsa!";
                    url = "/admin/proiecte-notificari/" + id;
                break;
                case "proiect_categorie_cheltuieli":
                    titlu="Stergere categorie cheltuieli";
                    text="Esti sigur ca vrei sa stergi categoria '"+nume+"'?";
                    confirmare="Categorie stearsa!";
                    esuare="Categoria NU a fost stearsa!";
                    url = "/admin/categorii-cheltuieli/" + id;
                break;
                case "grant_clasificare":
                    titlu="Stergere clasificare grant";
                    text="Esti sigur ca vrei sa stergi clasificarea '"+nume+"'?";
                    confirmare="Clasificare stearsa!";
                    esuare="Clasificarea NU a fost stearsa!";
                    url = "/admin/granturi-clasificari/" + id;
                break;
                case "grant":
                    titlu="Stergere clasificare grant";
                    text="Esti sigur ca vrei sa stergi grantul '"+nume+"'?";
                    confirmare="Grant sters!";
                    esuare="Grant NU a fost sters!";
                    url = "/admin/granturi/" + id;
                break;
                case "grant_mutare":
                    titlu="Stergere mutare valoare grant";
                    text="Esti sigur ca vrei sa stergi mutarea '"+nume+"'?";
                    confirmare="Mutare sters!";
                    esuare="Mutarea NU a fost stearsa!";
                    url = "/admin/granturi-mutari/" + id;
                break;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            el=$(this);
            e.preventDefault();
            Swal.fire({
                title: titlu,
                text: text,
                icon: "warning",
                showCancelButton: true,
                cancelButtonText:'Renunta',
                confirmButtonText:'Sterge'
            }).then(function (sters) {
                if(sters.value){
                    if(tip!='element'){
                        fisier='';
                    }
                    $.ajax({
                        type: "POST",
                        url: url,
                        data : {'_method' : 'DELETE', 'fisier':fisier},
                        cache: false,
                        success: function(response) {
                        if(!response){
                            Swal.fire(
                                "Succes!",
                                confirmare,
                                "success"
                            );
                            $("#"+tip+id).hide();
                            
                        }else{
                            if(response=='error'){
                                Swal.fire({
                                    title: "Eroare",
                                    html: `Acest element nu poate fi sters pentru ca este asociat altor elemente`,
                                    confirmButtonText: "Inchide",
                                    icon: "error",
                                });
                            }else{
                                Swal.fire({
                                    title: "Eroare",
                                    html: `Acest element nu se poate sterge pentru ca face parte din urmatoarele sectiuni:<br><ul class="listaOrdonata">`+response+`</ul>`,
                                    confirmButtonText: "Inchide",
                                    icon: "error",
                                });
                            }
                        }

                        },
                        error: function(response) {
                        Swal.fire(
                            "Error!",
                            esuare,
                            "error"
                        );
                        },
                    });

                }
            });

        });

        $(document).ready(function () {
            var counter = 1;
        
            $(".add-row1").on("click", function () {
                var newRow = $(".hidden-row1").clone().removeClass("hidden-row1").removeAttr("style")
                    .addClass('deleteable-row1');
                newRow.find("input").attr("required", true);
                newRow.find(".nr-crt").text(++counter);
                $(".tabela1 tbody").append(newRow);
            });
        
            $(".delete-row1").on("click", function () {
                if ($(".tabela1 tbody tr").length > 1) {
                    if ($(this).hasClass('clone-last-row1')) {
                        $(this).closest('.deleteable-row1').remove();
                        $(this).remove();
                    } else {
                        $(".tabela1 tbody tr:last-child").remove();
                    }
                    counter--;
                }
            });
        
            $(".clone-last-row1").on("click", function () {
                var lastRow = $(".tabela1 tbody tr:last").clone().removeClass("hidden-row1").removeAttr(
                    "style");
                lastRow.find(".nr-crt").text(++counter);
                lastRow.find(".delete-row1").addClass(
                    "delete-row1"); // Adaugă clasa `.delete-row2` butonului din rândul clonat
                lastRow.addClass('deleteable-row1'); // Adaugă clasa `.deleteable-row2` rândului clonat
                $(".tabela1 tbody").append(lastRow);
            });
        });
        
        $(document).ready(function () {
            var counter = 1;
        
            $(".add-row2").on("click", function () {
                var newRow = $(".hidden-row2").clone().removeClass("hidden-row2").removeAttr("style")
                    .addClass('deleteable-row2');
                newRow.find("input").attr("required", true);
                newRow.find(".nr-crt").text(++counter);
                $(".tabela2 tbody").append(newRow);
            });
        
            $(".delete-row2").on("click", function () {
                console.log('intra');
                if ($(".tabela2 tbody tr").length > 1) {
                    if ($(this).hasClass('clone-last-row2')) {
                        $(this).closest('.deleteable-row2').remove();
                        $(this).remove();
                    } else {
                        $(".tabela2 tbody tr:last-child").remove();
                    }
                    counter--;
                }
            });
        
            $(".clone-last-row2").on("click", function () {
                var lastRow = $(".tabela2 tbody tr:last").clone().removeClass("hidden-row2").removeAttr(
                    "style");
                lastRow.find(".nr-crt").text(++counter);
                lastRow.find(".delete-row2").addClass(
                    "delete-row2"); // Adaugă clasa `.delete-row2` butonului din rândul clonat
                lastRow.addClass('deleteable-row2'); // Adaugă clasa `.deleteable-row2` rândului clonat
                $(".tabela2 tbody").append(lastRow);
            });
        });
        
        $(document).ready(function () {
            var counter = 1;
        
            $(".add-row3").on("click", function () {
                var newRow = $(".hidden-row3").clone().removeClass("hidden-row3").removeAttr("style")
                    .addClass('deleteable-row3');
                newRow.find("input").attr("required", true);
                newRow.find(".nr-crt").text(++counter);
                $(".tabela3 tbody").append(newRow);
            });
        
            $(".delete-row3").on("click", function () {
                if ($(".tabela3 tbody tr").length > 1) {
                    if ($(this).hasClass('clone-last-row3')) {
                        $(this).closest('.deleteable-row3').remove();
                        $(this).remove();
                    } else {
                        $(".tabela3 tbody tr:last-child").remove();
                    }
                    counter--;
                }
            });
        
            $(".clone-last-row3").on("click", function () {
                var lastRow = $(".tabela3 tbody tr:last").clone().removeClass("hidden-row3").removeAttr(
                    "style");
                lastRow.find(".nr-crt").text(++counter);
                lastRow.find(".delete-row3").addClass(
                    "delete-row3"); // Adaugă clasa `.delete-row3` butonului din rândul clonat
                lastRow.addClass('deleteable-row3'); // Adaugă clasa `.deleteable-row3` rândului clonat
                $(".tabela3 tbody").append(lastRow);
            });
        });
        
        $(document).ready(function () {
            var counter = 1;
        
            $(".add-row4").on("click", function () {
                var newRow = $(".hidden-row4").clone().removeClass("hidden-row4").removeAttr("style")
                    .addClass('deleteable-row4');
                newRow.find("input").attr("required", true);
                newRow.find(".nr-crt").text(++counter);
                $(".tabela4 tbody").append(newRow);
            });
        
            $(".delete-row4").on("click", function () {
                if ($(".tabela4 tbody tr").length > 1) {
                    if ($(this).hasClass('clone-last-row4')) {
                        $(this).closest('.deleteable-row4').remove();
                        $(this).remove();
                    } else {
                        $(".tabela4 tbody tr:last-child").remove();
                    }
                    counter--;
                }
            });
        
            $(".clone-last-row4").on("click", function () {
                var lastRow = $(".tabela4 tbody tr:last").clone().removeClass("hidden-row4").removeAttr(
                    "style");
                lastRow.find(".nr-crt").text(++counter);
                lastRow.find(".delete-row4").addClass(
                    "delete-row4"); // Adaugă clasa `.delete-row4` butonului din rândul clonat
                lastRow.addClass('deleteable-row4'); // Adaugă clasa `.deleteable-row4` rândului clonat
                $(".tabela4 tbody").append(lastRow);
            });
        });
        
        $(document).ready(function () {
            var counter = 1;
        
            $(".add-row5").on("click", function () {
                var newRow = $(".hidden-row5").clone().removeClass("hidden-row5").removeAttr("style")
                    .addClass('deleteable-row5');
                newRow.find("input").attr("required", true);
                newRow.find(".nr-crt").text(++counter);
                $(".tabela5 tbody").append(newRow);
            });
        
            $(".delete-row5").on("click", function () {
                if ($(".tabela5 tbody tr").length > 1) {
                    if ($(this).hasClass('clone-last-row5')) {
                        $(this).closest('.deleteable-row5').remove();
                        $(this).remove();
                    } else {
                        $(".tabela5 tbody tr:last-child").remove();
                    }
                    counter--;
                }
            });
        
            $(".clone-last-row5").on("click", function () {
                var lastRow = $(".tabela5 tbody tr:last").clone().removeClass("hidden-row5").removeAttr(
                    "style");
                lastRow.find(".nr-crt").text(++counter);
                lastRow.find(".delete-row5").addClass(
                    "delete-row5"); // Adaugă clasa `.delete-row5` butonului din rândul clonat
                lastRow.addClass('deleteable-row5'); // Adaugă clasa `.deleteable-row5` rândului clonat
                $(".tabela5 tbody").append(lastRow);
            });
        });
    

        $('body').on('change', '.switch_theme input', function(e) {
            val=$(this).val();
            $('.box_switch i').removeClass('galben');
            if($(this).prop('checked')){
                createCookie('theme', 'dark', 90);
                $('.fa-moon').addClass('galben');
            }else{
                createCookie('theme', 'light', 90);
                $('.fa-sun').addClass('galben');
            }
            window.location.reload();
        });

        $('.select_id_utilizatori_custom').select2({
            allowClear: true,
            minimumInputLength: 3,
            inputTooShort: function(args) {
                return "Scrie mai multe caractere";
            },
            language: {
                noResults: function () {
                    return "Niciun rezultat gasit";
                },
                inputTooShort: function () {
                    return "Te rog introdu 3 sau mai multe caractere";
                },
                searching: function () {
                    return "Caut...";
                }
            },
            ajax: {
                type: "POST",
                delay: 250,
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                },
                url: '/ajax/ajaxCautaNumeUtilizator',
                data: function (params) {
                    return {
                        searchTerm: params.term,        
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
            },
        });

        $('body').on('click', '.marcheazaCitita', function(e) {
            id=$(this).data('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: '/ajax/ajaxMarcheazaNotificareCitita',
                data : {
                    'id' : id,
                },
                cache: false,
                success: function(response) {
                    $('#notificare'+id).find('.marcheazaCitita').html('<i class="fas fa-check-double"></i>');
                  $('#notificare'+id).find('.marcheazaCitita').addClass('disabled');
                  $('#notificare'+id).find('.marcheazaCitita').prop('disabled', true);
                    $('#notificare'+id).removeClass('bold');
                },
                error: function(response) {
                    swal.fire(
                        "Error!",
                        "A aparut o eroare!",
                        "error"
                    );
                },
            });
        });

        // MENIU -- adaugare elemente in BD
        $('body').on('click', '.adaugaInMeniu', function(e) {
            e.preventDefault();
            id_meniu=$('input[name="id_meniu"]').val();
            // campuri pagini & categorii
            elementeMeniu={};
            $(this).closest('form').find("input[name='elemente']:checked").each(function(){
                elementeMeniu[this.value]=$(this).closest('label').find('span').text();
            });
            // campuri link personalizat
            link_meniu=$(this).closest('form').find("input[name='link_meniu']").val();
            eticheta_meniu=$(this).closest('form').find("input[name='eticheta_meniu']").val();
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/ajax/ajaxAdaugaElemMeniu',
                data: {
                    'elem_meniu':JSON.stringify(elementeMeniu),
                    'link_meniu':link_meniu,
                    'eticheta_meniu':eticheta_meniu,
                    'id_meniu':id_meniu
                },
                success: function(response){
                    // refresh meniu in dreapta
                    $.ajax({
                        type: 'POST',
                        url: '/ajax/ajaxIncarcareMeniuAdmin',
                        data:{
                            'id_meniu':id_meniu
                        },
                        success: function(response){
                            $('.divMeniu').html(response);
                            $('input[type="checkbox"]').prop('checked',false)
                        }
                    });

                    // uncheck all checked elementeMeniu
                    $('input[name=elemente]').each(function(index,item){
                        if($(item).hasClass('checked')) {
                            $(item).trigger("click");
                        }
                    });
                    // empty input
                    $("input[name='eticheta_meniu']").val('');
                    $("input[name='link_meniu']").val('');
                }
            });
        });

        $('body').on('click', '.stergereAtasamentAnexa', function (e) {
            var id = $(this).data('id');
            var fisier = $(this).data('fisier');
            var anexa = $(this).data('anexa');

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            swal.fire({
            // title: "Sterge adresa "+tip,
            title: "Sigur doriți să ștergeți documentul?",
            showCancelButton: true,
            customClass: {
                container: 'swal_modifica_adresa',
                confirmButton: 'btn btn-mov-swal',
                cancelButton: 'btn btn-alb-swal'
            },
            confirmButtonText: "Sterge",
            cancelButtonText: "Renunta",
            }).then(function (sters) {
            if (sters.value) {
                $.ajax({
                    type: "POST",
                    url: '/ajax/ajaxStergereAtasamentAnexa',
                    data: {
                        'id': id,
                        'fisier': fisier,
                        'anexa': anexa,
                    },
                    cache: false,
                    success: function (response) {
                        if (response == 1) {
                            swal.fire({
                                title: "Succes!",
                                text: "Documentul a fost șters!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 3000)
                        } else {
                            swal.fire({
                                title: "Eroare!",
                                text: "Documentul nu a putut fi șters!",
                                icon: "error",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 3000)
                        }
                    },
                    error: function (response) {
                        swal.fire(
                            "Eroare!",
                            "A apărut o eroare!",
                            "error"
                        );
                    },
                });
            }
            });
        });


        $('body').on('click', '.stergereRandTabela', function (e) {
            var id = $(this).data('id');
            var index = $(this).data('index');
            var anexa = $(this).data('anexa');
            var autori = $(this).data('autori');

            console.log(autori);

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            swal.fire({
            // title: "Sterge adresa "+tip,
            title: "Sigur doresti sa stergi aceasta inregistrare din tabela?",
            showCancelButton: true,
            customClass: {
                container: 'swal_modifica_adresa',
                confirmButton: 'btn btn-mov-swal',
                cancelButton: 'btn btn-alb-swal'
            },
            confirmButtonText: "Sterge",
            cancelButtonText: "Renunta",
            }).then(function (sters) {
            if (sters.value) {
                $.ajax({
                    type: "POST",
                    url: '/ajax/ajaxStergereRandTabela',
                    data: {
                        'id': id,
                        'index': index,
                        'anexa': anexa,
                        'autori': autori,
                    },
                    cache: false,
                    success: function (response) {
                        if (response == 1) {
                            swal.fire({
                                title: "Succes!",
                                text: "Documentul a fost șters!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 3000)
                        } else {
                            swal.fire({
                                title: "Eroare!",
                                text: "Documentul nu a putut fi șters!",
                                icon: "error",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(function () {
                                location.reload();
                            }, 3000)
                        }
                    },
                    error: function (response) {
                        swal.fire(
                            "Eroare!",
                            "A apărut o eroare!",
                            "error"
                        );
                    },
                });
            }
            });
        });

        // meniu - update info element meniu
        $('body').on('click', '.btnSalveazaElementMeniu', function(e) {
            e.preventDefault();
            form=$(this).closest('.panel-collapse');

            id_elem_meniu=form.find("input[name='id_element_meniu']").val();

            // campuri link personalizat
            link_meniu=form.find("input[name='link_meniu']").val();
            eticheta_meniu=form.find("input[name='eticheta_meniu']").val();
            actiuni=[];

            inputDrepturi=form.find('.checkbox_drepturi input:checked');
            inputDrepturi.each(function(){
                actiuni.push(this.value);
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/ajax/ajaxUpdateElementMeniu',
                data: {
                    'id_element_meniu':id_elem_meniu,
                    'link_meniu':link_meniu,
                    'eticheta_meniu':eticheta_meniu,
                    'actiuni':actiuni
                },
                success: function(response){
                    form.parent('.panel').find('.eticheta_meniu').text(response);
                    $('#salvat'+id_elem_meniu).fadeIn('slow').animate({opacity: 1.0}, 1500).fadeOut('slow');
                }
            });
        });
    });
    function createCookie(name, value, days) {
        var expires;
    
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
    }
    
    function readCookie(name) {
        var nameEQ = encodeURIComponent(name) + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ')
                c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0)
                return decodeURIComponent(c.substring(nameEQ.length, c.length));
        }
        return null;
    }
    
    function eraseCookie(name) {
        createCookie(name, "", -1);
    }