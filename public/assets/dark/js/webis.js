    $(document).ready(function(){
        // stergere elemente
        $('body').on('click', '.stergere', function(e) {
            tip=$(this).data("tip");
            id=$(this).data("id");
            nume=$(this).data("nume");
            switch(tip){
                case "admin":
                    titlu="Stergere admin";
                    text="Esti sigur ca vrei sa stergi adminul '"+nume+"'?";
                    confirmare="Admin sters!";
                    esuare="Adminul NU a fost sters!";
                    url = "/admin/admini/" + id;
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
                            if(tip!='element'){
                                $("#"+tip+id).hide();
                            }else{
                                desters=el.data('desters');
                                $("#"+desters).hide();
                            }
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

    });