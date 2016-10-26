<?php  

function conectar_mysql() {
    
    $link = mysql_connect('localhost', 'root', '')
    or die('No se pudo conectar: ' . mysql_error());
mysql_select_db('unicob') or die('No se pudo seleccionar la base de datos');
return $link;
   
}
function esp_der($campo,$largo){
    for($i=  strlen($campo);$i<$largo;$i++){
        $campo.=' ';
    }
    return $campo;
}
function esp_izq($campo,$largo){
    for($i=  strlen($campo);$i<$largo;$i++){
        $campo=' '.$campo;
    }
    return $campo;
}
function cero_der($campo,$largo){
    for($i=  strlen($campo);$i<$largo;$i++){
         $campo.='0';
    }
    return $campo;
}
function cero_izq($campo,$largo){
    for($i=  strlen($campo);$i<$largo;$i++){
        $campo='0'.$campo;
    }
    return $campo;
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
            <div class="panel panel-primary col-lg-4">
                <div class="panel-heading">Subir Archivo</div>
                <div class="panel-body">
                    <form>
                        <input type="file" placeholder="Archivo" name="archivo">
                    </form>
                </div>
            </div>
            <div class="panel panel-primary col-lg-4">
                <div class="panel-heading">Archivo 200</div>
                <div class="panel-body">
                    <?php 
                    $arch="informes/traUNICOB_".date('Ymd').".txt";
                    $arch600="informes/600UNICOB_".date('Ymd').".txt";
                    $archtel="informes/telUNICOB_".date('Ymd').".txt";
                    $archdir="informes/dirUNICOB_".date('Ymd').".txt";
                    unlink($arch);
                    unlink($arch600);
                    unlink($archdir);
                    unlink($archtel);
                    fopen($archdir, 'a');
                    fopen($archtel, 'a');
                    fopen($arch600, 'a');
                    $archivo=  fopen($arch, 'a');
                    $cont='';
                        $sql="select distinct '2001' as cod3, ges.fecha,ges.cod_op,cod1.cod as cod1,cod2.cod2 as cod2,'UNICOB' as agente,substring(ges.comentario,1,56) as comentario,ges.fcontacto from gestionescla ges
inner join tmpop tmp on tmp.cod_op=ges.cod_op
inner join codigos cod1 on cod1.txt1=ges.contacto1
inner join codigos cod2 on cod2.txt2=ges.contacto2 ";
                        $res=  mysql_query($sql,  conectar_mysql());
                        while($a200=  mysql_fetch_array($res)){
                            $fechas=  explode('-',$a200['fecha']);
                            switch ($fechas[1]){
                                case 'ene':$nummes='01'; break;
                                case 'feb':$nummes='02'; break;
                                case 'mar':$nummes='03'; break;
                                case 'abr':$nummes='04'; break;
                                case 'may':$nummes='05'; break;
                                case 'jun':$nummes='06'; break;
                                case 'jul':$nummes='07'; break;
                                case 'ago':$nummes='08'; break;
                                case 'sep':$nummes='09'; break;
                                case 'oct':$nummes='10'; break;
                                case 'nov':$nummes='11'; break;
                                case 'dic':$nummes='12'; break;
                        }
                            $fecha=$nummes.$fechas[0].date('Y').' 00:00:00';
                            
                            $cont.=
                                    $a200['cod3']
                                    . esp_der($a200['cod_op'],25)
                                    .  $fecha
                                    . cero_izq('1', 3)
                                    .$a200['cod1']
                                    .$a200['cod2']
                                    .  esp_der(' ', 2)
                                    .  esp_izq($a200['agente'], 8)
                                    .  esp_izq(trim($a200['comentario']), 56)
                                    .  cero_izq($a200['fcontacto'], 13)
                                    .  cero_der('0', 8)
                                    .  chr(10);
                        }
                        fwrite($archivo,  $cont);
                        
                    ?>
                    <a href="<?php echo $arch ?>">Archivo 200</a>
            </div>
        </div>
    </body>
    <script>
        $(document).ready(function () {
            $("#tabla").DataTable();
        });

    </script>
</html>