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
            <div class="panel panel-primary">
                <div class="panel-heading">Registros Sin Compromiso y Contacto Titular</div>
                <div class="panel-body">
                    <table id="tabla" class="table">
                        <thead>
                            <tr>
                                <th>Rut</th>
                                <th>Gestiones</th>
                                <td>Fecha Gestion</td>
                                 <th>Tipo Gestion</th>
                                 <th>Resultado Gestion</th>
                                 <th>Comentario</th>
                                 <th>Fono Gestion</th>
                                 <th>Direccion</th>
                                 <th>Correo</th>
                                <th>Fecha Compromiso</th>
                                <th>Rut Usuario</th>
                                <th>Contacto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "select *,count(*) as num_gestiones from unicob.gestionescustomer gc 
inner join unicob.codigos cod on cod.cod2=gc.resultado_gestion and (gc.fecha_comp is null or gc.fecha_comp='') and gc.contacto='Titular'
group by gc.rut
order by cod.prioridad asc;
";
                            $res = mysql_query($sql, conectar_mysql());
                            while ($con = mysql_fetch_array($res)) {
                                echo "<tr>"
                                . "<td>" . $con['rut'] . "</td>"
                                . "<td>" . $con['num_gestiones'] . "</td>"
                                        . "<td>" . $con['fecha'] . "</td>"
                                        . "<td>" . $con['tipo_gestion'] . "</td>"
                                        . "<td>" . $con['resultado_gestion'] . "</td>"
                                        . "<td>" . $con['comentario'] . "</td>"
                                        . "<td>" . $con['area'].$con['telefono'] . "</td>"
                                        . "<td>" . $con['direccion'] . "</td>"
                                        . "<td>" . $con['correo'] . "</td>"
                                . "<td>" . $con['fecha_comp'] . "</td>"
                                        . "<td>" . $con['rut_usuario'] . "</td>"
                                . "<td>" . $con['contacto'] . "</td>"
                                . "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
        $(document).ready(function(){
            $("#tabla").DataTable();
        });
            </script>
    </body>
</html>