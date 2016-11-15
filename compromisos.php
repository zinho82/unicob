<?php require_once 'Superior.php'; ?>
<?php
switch ($_GET['d']){
    case 'a':  $sql = "select * from unicob.gestionescustomer ges where datediff(ges.fecha_comp,now())=-1";break;
    case 'h':   $sql = "select * from unicob.gestionescustomer ges where datediff(ges.fecha_comp,now())=0";break;
    case 'm': $sql = "select * from unicob.gestionescustomer ges where datediff(ges.fecha_comp,now())=1";break;
}
?>
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
            $("#tabla").DataTable({
                dom:'Bfrtip',
                buttons:[
                    'csv','excel','print'
                ]
            });
        });
            </script>
    </body>
</html>