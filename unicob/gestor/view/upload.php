<?php

function conectar_mysql() {

    $link = mysql_connect('localhost', 'root', '')
            or die('No se pudo conectar: ' . mysql_error());
    mysql_select_db('unicob') or die('No se pudo seleccionar la base de datos');
    return $link;
}

function duplicado($rut, $rg, $fecha, $hora, $op) {
     $sql = "select * from gestionescustomer where rut='$rut' and resultado_gestion='$rg' and fecha='$fecha' and hora_gestion='$hora' and rut_usuario='$op' ";
    $res = mysql_query($sql, conectar_mysql()) or die(mysql_error());
    return mysql_num_rows($res);
}

//comprobamos que sea una petición ajax
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    //obtenemos el archivo a subir
    $file = date("YmdGis") . "_" . $_FILES['arch']['name'];
    $file = str_replace(' ', '_', $file);
    //comprobamos si el archivo ha subido
    $fname = $_FILES['arch']['name'];
    $chk_ext = explode(".", $fname);

    if (strtolower(end($chk_ext)) == "csv") {
        //si es correcto, entonces damos permisos de lectura para subir
        $filename = $_FILES['arch']['tmp_name'];
        $handle = fopen($filename, "r");

        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            if (strlen($data[0]) > 0) {
                if (duplicado($data[0], $data[3], substr($data[1], 6, 4) . "-" . substr($data[1], 3, 2) . "-" . substr($data[1], 0, 2), substr($data[1], -5), $data[10]) < 1) {
                    //Insertamos los datos con los valores...
                  $sql = "INSERT   into gestionescustomer values( '$data[0]','" . substr($data[1], 6, 4) . "-" . substr($data[1], 3, 2) . "-" . substr($data[1], 0, 2) . "','" . substr($data[1], -5) . "','$data[2]','$data[3]','$data[4]', '$data[5]', '$data[6]', '$data[7]', '$data[8]','" . substr($data[9], 6, 4) . "-" . substr($data[9], 3, 2) . "-" . substr($data[9], 0, 2) . "', '$data[10]', '$data[11]','" . date('Y-m-d G:i:s') . "')";
                    mysql_query($sql, conectar_mysql()) or die(mysql_error());
                }
            }
        }
        //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
        fclose($handle);
        echo "Importación exitosa!";
        exit;
    } else {
        //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para             //ver si esta separado por " , "
        echo "Archivo invalido!";
        exit;
    }
    /*  if (move_uploaded_file($_FILES['arch']['tmp_name'],"../../archivos/".$file))
      {
      echo $sql="insert into archivos values(null,'".$_POST['campana']."',".$_POST['tipoarchivo'].",'$file','".$_POST['num_carga']."','".date('Y-m-d')."',4,'".$_POST['TipoCarga']."','".$_FILES['arch']['name']."')";
      mysql_query($sql,  conectar_mysql()) or die( mysql_error());
      sleep(3);//retrasamos la petición 3 segundos
      echo $file;//devolvemos el nombre del archivo para pintar la imagen
      }
      else{
      echo "  no cargo ";
      } */
} else {
    echo "NO FUNCO";
    // throw new Exception("Error Processing Request", 1);   
}