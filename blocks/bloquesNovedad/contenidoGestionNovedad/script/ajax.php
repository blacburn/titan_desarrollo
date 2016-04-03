<?php
// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";
//Variables
$cadenaACodificar17 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar17 .= "&procesarAjax=true";
$cadenaACodificar17 .= "&action=index.php";
$cadenaACodificar17 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar17 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar17 .= $cadenaACodificar17 . "&funcion=consultarTipoVinculacionAjax";
$cadenaACodificar17 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena17 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar17, $enlace);
// URL definitiva
$urlFinal17 = $url . $cadena17;
?>

<script>
    $('#<?php echo $this->campoSeguro('fdpTipoVinculacion') ?>').width(240);
    $("#<?php echo $this->campoSeguro('fdpTipoVinculacion') ?>").select2();


    var table = $('#tablaReporte').DataTable();
    function consultarTipoVinculacion(elem, request, response) {
        var tableNueva = $('#tablaReporte').DataTable();
        $.ajax({
            url: "<?php echo $urlFinal17 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('fdpTipoVinculacion') ?>").val()},
            success: function (data) {

                if (data[0] != " ") {
                    $.each(data, function (indice, valor) {
                        tableNueva.row.add([data[ indice ].nombres,
                            data[ indice ].nombres,
                            data[ indice ].nombres,
                            data[ indice ].nombres,
                            data[ indice ].nombres,
                            data[ indice ].nombres
                        ]).draw(false);

                    });
                }





            }

        });

    }


    $(function () {

        $("#<?php echo $this->campoSeguro('fdpTipoVinculacion') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('fdpTipoVinculacion') ?>").val() != ' ') {
              
                consultarTipoVinculacion();
            }
        });


    });

</script>