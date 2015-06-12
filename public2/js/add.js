$(function () {



    $('.guardarCliente').click(function () {
        console.info("aca llega");
        var nombre = $('#nombre').val();

        var baseUrl = 'factores/add';
        var dataString = 'nombre_cliente=' + nombre;

        $.ajax({
            data: nombre,
            url: 'factores/add',
            type: 'post',
            beforeSend: function () {
                
                $("#resultado").html("Procesando, espere por favor...");

            },
            success: function (response) {
                
                $("#resultado").html(response);

            }

        });

console.info("aca llega-...");
        $('#nombre').val('');
        return false;
    });
});



