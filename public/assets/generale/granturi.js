function actualizeazaValoriGranturi(){
    autori_straini=$('input[name="autori_straini"]:checked').val();
    id_clasificare=$('select[name="id_grant_clasificare"]').val();
    var nr_autori_utcn = $("input[name='id_autor_utcn[]']").filter(function() {
        return $(this).val() !== "";
    }).length;

    var nr_autori_externi = $("input[name='autori_externi_grant[]']").filter(function() {
        return $(this).val() !== "";
    }).length;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: "/ajax/ajaxCalculeazaValoriGranturi",
        data : {
            'autori_straini' : autori_straini,
            'id_clasificare':id_clasificare,
            'nr_autori_utcn':nr_autori_utcn,
            'nr_autori_externi':nr_autori_externi,
        },
        cache: false,
        success: function(response) {
            obj=JSON.parse(response);
            $('.valoare_totala_grant').val(obj.valoare_grant);
            $('.valoare_utcn').val(obj.valoare_utcn);
            $('.valoare_cota_parte').val(obj.valoare_cota_parte);
            $('input[name="valoare_cota_parte_autor[]"]').val(obj.valoare_cota_parte);
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


$(document).ready(function(){
    $('body').on('change', 'select[name="id_grant_cerere"]', function(e) {
        if($(this).val()=='0'){
            $('input[name="id_grant_cerere_custom"]').removeClass('d-none');
        }else{
            $('input[name="id_grant_cerere_custom"]').val('');
            $('input[name="id_grant_cerere_custom"]').addClass('d-none');
        }
    });


    $('body').on('click', '.actualizeazaValoriGranturi', function(e) {
        actualizeazaValoriGranturi();
    });

    // mutari valori granturi -- hide acelasi autor
    $('body').on('change', 'select[name="id_cd_sursa"]', function(e) {
        id_cd_sursa=$(this).val();
        id_grant=$('input[name="id_grant"]').val();
        id_cd_destinatie=$('select[name="id_cd_destinatie"]').val();
        if(id_cd_destinatie==id_cd_sursa){
            $('select[name="id_cd_destinatie"]').val('');
        }
        $('select[name="id_cd_destinatie"] option').show();
        $('select[name="id_cd_destinatie"] option[value='+id_cd_sursa+']').hide();

        $('input[name="valoare_mutata"]').val('');
        $('input[name="valoare_mutata"]').attr('max', '');
        // verificare val maxim suma ramasa
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '/ajax/ajaxGetSumaRamasaAutorGrant',
            data : {
                'id_grant':id_grant,
                'id_cd_sursa':id_cd_sursa,
            },
            cache: false,
            success: function(response) {
                $('input[name="valoare_mutata"]').attr('max', response);
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

    $('body').on('change', 'select[name="id_cd_destinatie"]', function(e) {
        id_cd_destinatie=$(this).val();
        id_cd_sursa=$('select[name="id_cd_sursa"]').val();
        if(id_cd_destinatie==id_cd_sursa){
            $('select[name="id_cd_sursa"]').val('');
        }
        $('select[name="id_cd_sursa"] option').show();
        $('select[name="id_cd_sursa"] option[value='+id_cd_destinatie+']').hide();
    });

    $('body').on('keyup', 'input[name="valoare_mutata"]', function(e) {
        val=$(this).val();
        max_val=$(this).attr('max');
        
        if(parseFloat(val)>parseFloat(max_val)){
            $(this).val(max_val);
        }
    });

    
});

function mesajAddMutare(){
    Swal.fire({
        title: 'Esti sigur ca adaugi mutarea de valoare?',
        text: 'Nu vei putea sa o modifici sau sa o stergi dupa ce mutarea va fi adaugata',
        icon: "warning",
        showCancelButton: true,
        cancelButtonText:'Renunta',
        confirmButtonText:'Adauga'
    }).then(function (val) {
        if(val.value){
            console.log('merge');
            $('#formMutareValoareGrant').submit();
        }
        return false;
    });
}