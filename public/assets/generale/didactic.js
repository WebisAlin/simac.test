$(document).ready(function(){

    $('body').on('click', '.stergere', function(e) {
        tip=$(this).data("tip");
        id=$(this).data("id");
        nume=$(this).data("nume");
        switch(tip){
            case "grant-cerere":
                titlu="Stergere cerere";
                text="Esti sigur ca vrei sa stergi cererea '"+nume+"'?";
                confirmare="Cerere stearsa!";
                esuare="Cererea NU a fost stearsa!";
                url = "/cereri-granturi/" + id;
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


    
   $('body').on('click', '.stergereCerere', function (e) {
    id = $(this).data('id');
          $.ajaxSetup({
             headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
          });
          $.ajax({
             type: "POST",
             url: '/ajax/ajaxDeleteCerereInitiata',
             data: {
                'id': id,
             },
             cache: false,
             success: function (response) {
                if(response == 1){
                   swal.fire({
                      title: "Succes!",
                      text: "Cererea nu poate sa fie stearsa!",
                      showConfirmButton: false,
                      icon: "error",
                      timer: 2000
                   });
                   setTimeout(function () {
                      location.reload();
                   }, 3000)
                }else{
                   swal.fire({
                      title: "Succes!",
                      text: "Cererea a fost stearsa!",
                      showConfirmButton: false,
                      icon: "success",
                      timer: 2000
                   });
                   setTimeout(function () {
                      location.reload();
                   }, 3000)
                }
             },
             error: function (response) {
                swal.fire(
                   "Error!",
                   "An error occurred!",
                   "error"
                );
             },
          });
    });


    $('body').on('click', '.perioadaPontaje', function(e) {
        e.preventDefault();
        luna=$('select[name="luna"]').val();
        an=$('select[name="an"]').val();
        id_cd=$('input[name="id_cd"]').val();
        id_proiect=$('input[name="id_proiect"]').val();
        actiune=$('input[name="actiune"]').val();

        link="/pontaje/"+actiune+"/"+id_proiect+"/"+id_cd+"/"+jQuery.trim(luna)+"/"+an;
        Swal.fire({
            title: "Atentie!",
            text: "Inainte de a reseta perioada, daca ai efectuat modificari, te rugam sa le salvezi",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText:'Renunta',
            confirmButtonText:'Schimba perioada'
        }).then(function (da) {
            if(da.value){
                window.location.href=link;
            }
        });
    });
    $('body').on('click', '.btnValideazaPontaj', function(e) {
        e.preventDefault();
        id=$(this).data('id');
        el=$(this);
        Swal.fire({
            title: "Validare pontaj",
            text: "Esti sigur ca validezi pontajul?",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText:'Renunta',
            confirmButtonText:'Valideaza'
        }).then(function (da) {
            if(da.value){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '/ajax/ajaxValideazaPontaj',
                    data : {
                        'id_pontaj' : id,
                    },
                    cache: false,
                    success: function(response) {
                        el.addClass('disabled');
                        el.removeClass('valideazaPontaj');
                        swal.fire(
                            "Succes!",
                            "Pontajul a fost validat!",
                            "success"
                        );
                    },
                    error: function(response) {
                        swal.fire(
                            "Error!",
                            "A aparut o eroare!",
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

});