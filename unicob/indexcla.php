<?php  
date_default_timezone_set('America/Santiago');
function conectar_mysql() {
    
    $link = mysql_connect('localhost', 'zinho', 'zinho1982')
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
                    $archivo600=fopen($arch600, 'a');
                    $archivo=  fopen($arch, 'a');
                    $cont='';
                    $cont6="";
                        $sql="select distinct '2006' as cod3,ges.fecges, ges.feccom,ges.cod_op,'UNICOB' as agente,cod1.cod,cod2.cod2,substring(ges.dertalle,1,56) as comentario,ges.fonocon from gestionescla ges
inner join codigos cod1 on cod1.txt1=upper(ges.codaccion)
inner join codigos cod2 on cod2.txt2=upper(ges.dertalle) "; 
                        $res=  mysql_query($sql,  conectar_mysql()) or die(mysql_error());
                        while($a200=  mysql_fetch_array($res)){
                            $fecha=  explode('/', $a200['fecges']);
                            if(strlen($fecha[2])==2){
                                $ano=date('Y');
                            }
                            else{
                                $ano=$fecha[2];
                            }
                            $cont.=
                                    $a200['cod3']
                                    . esp_der($a200['cod_op'],25)
                                    .  $fecha[1].$fecha[0].$ano.' 00:00:00'
                                    . cero_izq('1', 3)
                                    .$a200['cod']
                                    .$a200['cod2']
                                    .  esp_der(' ', 2)
                                    .  esp_izq($a200['agente'], 8)
                                    .  esp_izq(trim($a200['comentario']), 56)
                                    .  cero_izq($a200['fonocon'], 13)
                                    .  cero_der('0', 8)
                                    .  chr(10);
                        }
                        fwrite($archivo,  $cont);
                         $sql="select distinct '6001' as cod3,ges.mora_rut,ges.fecges ,ges.feccom,ges.cod_op,'UNICOB' as agente,cod1.cod,cod2.cod2,substring(ges.dertalle,1,56) as comentario,ges.fonocon from gestionescla ges
inner join codigos cod1 on cod1.txt1=upper(ges.codaccion)
inner join codigos cod2 on cod2.txt2=upper(ges.dertalle) and cod2.cod2='PP'";
                        $res=  mysql_query($sql,  conectar_mysql());
                        while($a600=  mysql_fetch_array($res)){
                            $fecha=  explode('/', $a600['fecges']);
                            $fechaprom=  explode('/', $a600['feccom']);
                           $cont6.=
                                    $a600['cod3']
                                    . esp_der($a600['cod_op'],25)
                                   
                                   .  cero_der('0', 8)
                                    .$a600['cod']
                                    .$a600['cod2']
                                    . esp_der($fecha[1].$fecha[0].$fecha[2] ,8)
                                    .'001001'
                                   .esp_der($fechaprom[1].$fechaprom[0].$fechaprom[2],8)
                                   . cero_izq($a600['mora_rut'].'00', 15)
                                    .  chr(10); 
                        }
                        fwrite($archivo600,  $cont6);
                    ?>
                    <a href="<?php echo $arch ?>">Archivo 200</a><br>
                    <a href="<?php echo $arch600 ?>">Archivo 600</a>
            </div>
        </div>
    </body>
    <script>
        $(document).ready(function () {
            $("#tabla").DataTable();
        });

    </script>
</html>