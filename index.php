<?php

function conectar_mysql() {

    $link = mysql_connect('localhost', 'root', '')
            or die('No se pudo conectar: ' . mysql_error());
    mysql_select_db('unicob') or die('No se pudo seleccionar la base de datos');
    return $link;
}
?>

<html>
    <head>
        <title>...:UNICOB:...</title>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">

        <script type="text/javascript" charset="utf8" src="http://cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>


    <body>
        <div class="row">
            <div class="panel panel-primary col-lg-6">
                <div class="panel-heading">Resumen Recurrencia Titulares sin compromiso</div>
                <div class="panel-body">
                    <table id="tablatsc" class="table">
                        <thead>
                            <tr><td colspan="5"><button type="button" onclick="location.href = 'salida.php?tipo=sc';"  id="exoportar" class="btn btn-block btn-success">Exportar</button></td></tr>
                            <tr>
                                <th>Rut</th>
                                <th>Gestiones</th>
                                <th>Fecha Contacto</th>
                                <th>Resultado Gestion</th>
                                <th>Fecha Compromiso</th>
                                <th>Contacto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                           $sql = "select *,count(*) as num_gestiones from unicob.gestionescustomer gc 
inner join unicob.codigos cod on cod.cod2=gc.resultado_gestion and (gc.fecha_comp is null or gc.fecha_comp='') and gc.contacto='Titular'
group by gc.rut
order by cod.prioridad asc
";
                            $res = mysql_query($sql, conectar_mysql());
                            while ($con = mysql_fetch_array($res)) {
                                echo "<tr>"
                                . "<td>" . $con['rut'] . "</td>"
                                . "<td>" . $con['num_gestiones'] . "</td>"
                                . "<td>" . $con['fecha'] . "</td>"        
                                . "<td>" . $con['txt2'] . "</td>"
                                . "<td>" . $con['fecha_comp'] . "</td>"
                                . "<td>" . $con['contacto'] . "</td>"
                                . "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel panel-primary col-lg-6">
                <div class="panel-heading">Resumen Recurrencia Titulares con Compromiso</div>
                <div class="panel-body">
                    <table id="tablatc" class="table">
                        <thead>
                            <tr><td colspan="5"><button type="button" onclick="location.href = 'salida1.php?tipo=sc';"  id="exoportar" class="btn btn-block btn-success">Exportar</button></td></tr>
                            <tr>
                                <th>Rut</th>
                                <th>Gestiones</th>
                                <th>Fecha Contacto</th>
                                <th>Resultado Gestion</th>
                                <th>Fecha Compromiso</th>
                                <th>Contacto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                          $sql = "select *,count(*) as num_gestiones from unicob.gestionescustomer gc 
inner join unicob.codigos cod on cod.cod2=gc.resultado_gestion and gc.fecha_comp!='' and gc.contacto='Titular'
group by gc.rut
order by cod.prioridad asc;
";
                            $res = mysql_query($sql, conectar_mysql());
                            while ($con = mysql_fetch_array($res)) {
                                echo "<tr>"
                                . "<td>" . $con['rut'] . "</td>"
                                . "<td>" . $con['num_gestiones'] . "</td>"
                                . "<td>" . $con['fecha'] . "</td>"        
                                . "<td>" . $con['txt2'] . "</td>"
                                . "<td>" . $con['fecha_comp'] . "</td>"
                                . "<td>" . $con['contacto'] . "</td>"
                                . "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel panel-primary col-lg-12">
                <div class="panel-heading">Registros recorridos Customer</div>
                <div class="panel-body">
                    <table class="table" id="tabla">
                        <thead>
                        <th>Rut</th>
                        <th>Fecha Gestion</th>
                        <th>Tipo Gestion</th>
                        <th>Resultado Gestion</th>
                        <th>Comentario</th>
                        <th>Area</th>
                        <th>Telefono</th>
                        <th>Direccion</th>
                        <th>Correo</th>
                        <th>Fecha de Compromiso</th>
                        <th>Rut Usuario</th>
                        <th>Contacto</th>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select * from unicob.gestionescustomer";
                            $res = mysql_query($sql, conectar_mysql()) or die(mysql_error());
                            /*        while ($glo = mysql_fetch_array($res)) {
                              echo "<tr>"
                              . "<td>" . glo['rut'] . "</td>"
                              . "<td>" . $glo['fecha'] . "</td>"
                              . "<td>" . $glo['tipo_gestion'] . "</td>"
                              . "<td>" . $glo['resultado_gestion'] . "</td>"
                              . "<td>" . $glo['comentario'] . "</td>"
                              . "<td>" . $glo['area'] . "</td>"
                              . "<td>" . $glo['telefono'] . "</td>"
                              . "<td>" . $glo['direccion'] . "</td>"
                              . "<td>" . $glo['correo'] . "</td>"
                              . "<td>" . $glo['fecha_comp'] . "</td>"
                              . "<td>" . $glo['rut_usuario'] . "</td>"
                              . "<td>" . $glo['contacto'] . "</td>"
                              . "</tr>";
                              } */
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
    <script>
        $(document).ready(function () {
            $("#tabla").DataTable();
            $("#tablatsc").DataTable();
            $("#tablatc").DataTable();
        });

    </script>
</html>