<?php require_once 'Superior.php'; ?>

<div class="row col-lg-12">
    <div class="panel panel-primary col-lg-2">
        <div class="panel-heading">Dias Cargados mes de <?php echo date('M')?></div>
        <div class="panel-body">
            <table class="table" id="dias">
                <thead>
                <th>Dia</th>
                <th>Registros</th>
                </thead>
                <tbody>
                    <?php
                    $sql="select count(*) as cant, fecha from gestionescustomer group by fecha";
                    $res=  mysql_query($sql,  conectar_mysql());
                    while($dia=  mysql_fetch_array($res)){
                    echo "<tr><td>".$dia['fecha']."</td><td align='rigth'>".number_format($dia['cant'],0,',','.')."</td></tr>";
                    }
                    ?>
                    
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
    <div class="panel panel-primary col-lg-3">
        <div class="panel-heading">Compromisos de Pago</div>
        <div class="panel-body">
            <table class="table">
                <thead>
                <th>Ayer</th>
                <th>Hoy</th>
                <th>Mañana</th>
                </thead>
                <tbody>
                    <?php 
                    $sql="select 
count(*) as hoy,
(select  count(*) from gestionescustomer cu where datediff(cu.fecha_comp,date(now()))=-1) as ayer ,
(select  count(*) from gestionescustomer cu where datediff(cu.fecha_comp,date(now()))=1) as mana 
from gestionescustomer cu where cu.fecha_comp=date(now())";
                    $res=  mysql_query($sql,  conectar_mysql());
                    $re=  mysql_fetch_assoc($res);
                    echo "<tr><td><a title='Mostrar Compromiso' href='compromisos.php?d=a'>".$re['ayer']."</a></td><td><a title='Mostrar Compromiso' href='compromisos.php?d=h'>".$re['hoy']."</a></td><td><a title='Mostrar Compromiso' href='compromisos.php?d=m'>".$re['mana']."</a></td></tr>";
                    ?> 
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row col-lg-12">
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
inner join unicob.codigos cod on cod.cod2=gc.resultado_gestion and (gc.fecha_comp is null or gc.fecha_comp='' or gc.fecha_comp='0000-00-00') and gc.contacto='Titular' and month(gc.feccarga)='" . date('m') . "'
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
                        <th>Hora Gestion</th>
                        <th>Resultado Gestion</th>
                        <th>Fecha Compromiso</th>
                        <th>Contacto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "select *,(select count(*) from unicob.gestionescustomer cons where cons.rut=gc.rut) as num_gestiones from unicob.gestionescustomer gc 
inner join unicob.codigos cod on cod.cod2=gc.resultado_gestion and gc.fecha_comp!='0000-00-00' and gc.contacto='Titular' and month(gc.feccarga)='" . date('m') . "'
group by gc.rut
order by cod.prioridad asc;
";
                    $res = mysql_query($sql, conectar_mysql());
                    while ($con = mysql_fetch_array($res)) {
                        echo "<tr>"
                        . "<td>" . $con['rut'] . "</td>"
                        . "<td>" . $con['num_gestiones'] . "</td>"
                        . "<td>" . $con['fecha'] . "</td>"
                        . "<td>" . $con['hora_gestion'] . "</td>"
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
            <table class="table" id="tablas">
                <thead>
                <th>Rut</th>
                <th>Fecha Gestion</th>
                <th>Hora Gestion</th>
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
                    $sql = "select * from gestionescustomer inner join codigos on cod2=resultado_gestion";
                    $res = mysql_query($sql, conectar_mysql()) or die(mysql_error());
                    while ($glo = mysql_fetch_array($res)) {
                        echo "<tr>"
                        . "<td>" . $glo['rut'] . "</td>"
                        . "<td>" . $glo['fecha'] . "</td>"
                        . "<td>" . $glo['hora_gestion'] . "</td>"
                                . "<td>" . $glo['txt1'] . "</td>"
                        . "<td>" . $glo['txt2'] . "</td>"
                        . "<td>" . $glo['comentario'] . "</td>"
                        . "<td>" . $glo['area'] . "</td>"
                        . "<td>" . $glo['telefono'] . "</td>"
                        . "<td>" . $glo['direccion'] . "</td>"
                        . "<td>" . $glo['correo'] . "</td>"
                        . "<td>" . $glo['fecha_comp'] . "</td>"
                        . "<td>" . $glo['rut_usuario'] . "</td>"
                        . "<td>" . $glo['contacto'] . "</td>"
                        . "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
<script>
    $(document).ready(function () {
        $("#tablas").DataTable();
        $("#tablatsc").DataTable();
        $("#tablatc").DataTable();
        $("#dias").DataTable();
    });

</script>
</html>