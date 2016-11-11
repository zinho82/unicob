<?php
require_once '../../Superior.php';
?>
    <div class="row col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading">Gestor de Archivos</div>
            <div class="panel-body">
                <form id="BuscaCampana" method="post" enctype="multipart/form-data" >
                    <select class="form-control" name="tipoarchivo" id="tipoarchivo">
                        <option selected="">Seleccione Tipo Archivo</option>
                        <option value="1">Pagos Consumer</option>
                        <option value="2">Ficha Gestion Consumer</option>
                    </select>
                   
                    
                    <input   name="arch" id="arch" type="file">
                    </div>
                    <input type="button" id="Subir" class="btn btn-block btn-success"   value="Cargar">
                </form>
                <div id="msg"></div>
            </div>
        </div>
<script>
    $(document).ready(function () {
        $("#cargarArch").attr("disabled", true);
        $("#Subir").attr("disabled", true);
        $("#Subir").attr("disabled", false); 
        $("#Subir").attr("class", "btn btn-block btn-success"); 
        $("#arch").click(function(){
             $("#Subir").attr("disabled", false);
             $("#Subir").attr("class", "btn-success btn btn-block");
            
        });
        $("#Subir").click(function () {
            var formData = new FormData($("#BuscaCampana")[0]);
            $.ajax({
                url: 'upload.php',
                type: 'POST',
                // Form data
                //datos del formulario
                data: formData,
                //necesario para subir archivos via ajax
                cache: false,
                contentType: false,
                processData: false,
                //mientras enviamos el archivo
                beforeSend: function () {
                    $("#msg").attr("class", "alert alert-info");
                    $("#msg").html("Comenzando la carga");
                },
                //una vez finalizado correctamente
                success: function (formData) {
                    $("#msg").html(formData);

                },
                //si ha ocurrido un error
                error: function () {
                    $("#msg").html("Error al Cargar Archivo");
                }
            });

        });
    });
</script>
