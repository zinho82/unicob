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
        <title>...:UNICOB - Castigo:...</title>
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
            <div class="panel panel-primary col-lg-9">
                <div class="panel-heading">Resumen por Ejecutivo (Montos X 1000)</div>
                <div class="panel-body">
                    <table id="tablatsc" class="table">
                        <thead>
                            <tr><td colspan="5"><button type="button" onclick="location.href = 'salida.php?tipo=sc';"  id="exoportar" class="btn btn-block btn-success">Exportar</button></td></tr>
                            <tr>
                                <th>Ejecutivo</th>
                                <th>Registros</th>
                                <th>Monto a Gestionar</th>
                                <th>% Monto a Gestionar</th>
                                <th>Registros Gestionados</th>
                                <th>% Monto Gestionado</th>
                                <th>Monto Gestionado</th>
                                <th>Meta Cumplida</th>
                                <th>Meta Mes</th>
                                <th>% Meta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select count(*) as cant,ca.ejecutivo,sum(ca.saldo)/1000 as montoges,((sum(ca.saldo))/(select sum(cas.saldo) from unicob.castigo_noviembre cas)*100) as pormonges,(select sum(cas.saldo) from unicob.castigo_noviembre cas) as totmeta from unicob.castigo_noviembre ca group by ejecutivo";
                            $res = mysql_query($sql, conectar_mysql());
                            while ($con = mysql_fetch_array($res)) {
                                echo "<tr>"
                                . "<td>" . $con['ejecutivo'] . "</td>"
                                . "<td>" . $con['cant'] . "</td>"
                                . "<td>" . number_format($con['montoges'], 2, ',', '.') . "</td>"
                                . "<td>" . number_format($con['pormonges'], 2, ',', '.') . "%</td>"
                                . "<td></td>"
                                . "<td></td>"
                                . "<td></td>"
                                . "<td></td>"
                                . "<th>" . number_format($con['totmeta'] * (1 / 100), 0, ',', '.') . "</th>"
                                . "<th></th>"
                                . "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel panel-primary col-lg-6">
                <div class="panel-heading">Segmentacion BD (Regiones)</div>
                <div class="panel-body">
                    <table id="tablatc" class="table">
                        <thead>
                            <tr><td colspan="5"><button type="button" onclick="location.href = 'salida1.php?tipo=sc';"  id="exoportar" class="btn btn-block btn-success">Exportar</button></td></tr>
                            <tr>
                                <th>Region</th>
                                <th>Registros</th>
                                <th>Monto Gestion</th>
                                <th>% Monto Gestion</th>
                                <th>Monto Gestionado</th>
                                <th>% Gestionado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select count(*) as cant,ca.region,sum(ca.saldo)/1000 as montoges,((sum(ca.saldo))/(select sum(cas.saldo) from unicob.castigo_noviembre cas)*100) as pormonges from unicob.castigo_noviembre ca group by ca.region
";
                            $res = mysql_query($sql, conectar_mysql());
                            while ($con = mysql_fetch_array($res)) {
                                echo "<tr>"
                                . "<td>" . $con['region'] . "</td>"
                                . "<td>" . $con['cant'] . "</td>"
                                . "<td>" .number_format( $con['montoges'],2,',','.') . "</td>"
                                . "<td>" .number_format( $con['pormonges'],2,',','.') . "%</td>"
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
                <div class="panel-heading">Segmentacion BD (Tramo de Mora)</div>
                <div class="panel-body">
                    <table id="tablatm" class="table">
                        <thead>
                            <tr><td colspan="5"><button type="button" onclick="location.href = 'salida1.php?tipo=sc';"  id="exoportar" class="btn btn-block btn-success">Exportar</button></td></tr>
                            <tr>
                                <th>Region</th>
                                <th>Registros</th>
                                <th>Monto Gestion</th>
                                <th>% Monto Gestion</th>
                                <th>Monto Gestionado</th>
                                <th>% Gestionado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select count(*) as cant,ca.region,sum(ca.saldo)/1000 as montoges,((sum(ca.saldo))/(select sum(cas.saldo) from unicob.castigo_noviembre cas)*100) as pormonges from unicob.castigo_noviembre ca group by ca.region
";
                            $res = mysql_query($sql, conectar_mysql());
                            while ($con = mysql_fetch_array($res)) {
                                echo "<tr>"
                                . "<td>" . $con['region'] . "</td>"
                                . "<td>" . $con['cant'] . "</td>"
                                . "<td>" .number_format( $con['montoges'],2,',','.') . "</td>"
                                . "<td>" .number_format( $con['pormonges'],2,',','.') . "%</td>"
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
                <div class="panel-heading">Segmentacion BD (Tipo Producto)</div>
                <div class="panel-body">
                    <table id="tablaprod" class="table">
                        <thead>
                            <tr><td colspan="5"><button type="button" onclick="location.href = 'salida1.php?tipo=sc';"  id="exoportar" class="btn btn-block btn-success">Exportar</button></td></tr>
                            <tr>
                                <th>Producto</th>
                                <th>Registros</th>
                                <th>Monto Gestion</th>
                                <th>% Monto Gestion</th>
                                <th>Monto Gestionado</th>
                                <th>% Gestionado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select count(*) as cant,sum(ca.saldo)/1000 as montoges,((sum(ca.saldo))/(select sum(cas.saldo) from unicob.castigo_noviembre cas)*100) as pormonges from unicob.castigo_noviembre ca group by (ca.saldo/1000)
";
                            $res = mysql_query($sql, conectar_mysql());
                            while ($con = mysql_fetch_array($res)) {
                                echo "<tr>"
                                . "<td>" . $con['montoges'] . "</td>"
                                . "<td>" . $con['cant'] . "</td>"
                                . "<td>" . number_format($con['montoges'],2,',','.') . "</td>"
                                . "<td>" . number_format($con['pormonges'],2,',','.') . "%</td>"
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
            $("#tablaprod").DataTable();
            $("#tablatm").DataTable();
        });

    </script>
</html>