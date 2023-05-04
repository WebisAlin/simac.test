$(document).ready(function(){
    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
    });


    $('body').on('keyup', '.cauta', function(e) {
        valoare=$(this).val();
        tip=$(this).data('tip');
        
        el=$(this);
        switch (tip) {
            case 'cadre-didactice':
                url='/ajax/ajaxCautareCadruDidactic';
            break;
            case 'universitati':
                url='/ajax/ajaxCautareUniversitate';
            break;
        }
        if(valoare.length>=1){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: url,
                data : {
                    'valoare' : valoare,
                    'tip':tip,
                },
                cache: false,
                success: function(response) {
                    el.parent().find(".rezultateCautare").show();
                    el.parent().find(".rezultateCautare").html(response);
                },
                error: function(response) {
                    swal.fire(
                    "Error!",
                    "A aparut o eroare!",
                    "error"
                    );
                },
            });
            if(valoare.length<3){
                el.parent().find('input[type="hidden"]').val('');
            }
        }else{
            $(".rezultateCautare").hide();
            el.parent().find('input[type="hidden"]').val('');
        }
    });

    $('body').on('click', '.rezultateCautare li:not(.disabled)', function () {
        text = $(this).text();
        id = $(this).attr('id');
        if(id){
            $(this).parent().parent().find(".cauta").val(jQuery.trim(text));
            $(this).parent().parent().find('input[type="hidden"]').val(id);
            $(this).parent().parent().find(".rezultateCautare").hide();
            input=$(this).parent().parent('.form-group').find('input[type="hidden"]').attr('name');
            if(input=='id_cd'){
                // refill select cereri
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
    
                $.ajax({
                    type: "POST",
                    url: "/ajax/ajaxPreluareCereriGranturiCD",
                    data : {
                        'id_cd' : id,
                    },
                    cache: false,
                    success: function(response) {
                        $('select[name="id_grant_cerere"]').html(response)
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
        }
    });

    $('body').on('click', '.btnAdd', function(e) {
        box=$(this).closest('.boxMultiplicare');
        nr=box.find('.tabelaArticole .randTabela').length;
        elemDeAdaugat=box.find('.tabelaArticole .randTabela.d-none').clone();
        elemDeAdaugat=elemDeAdaugat.find('input').val('').end();
        elemDeAdaugat=elemDeAdaugat.removeClass('d-none');
        
        box.find('.tabelaArticole .randTabela:last').append(elemDeAdaugat);
        elemDeAdaugat.appendTo(box.find('.tabelaArticole'));
    });

    $('body').on('click', '.btnRemoveRand', function(e) {
        e.preventDefault();
        box=$(this).closest('.boxMultiplicare');
        nr=box.find('.tabelaArticole .randTabela').length;
        if(nr>2){ // pt ca este un div hidden 
            $(this).closest('.randTabela').remove();
        }else{
            $(this).closest('.randTabela')
            .find('input').val('').end();
        }
    });
});