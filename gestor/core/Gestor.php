<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gestor
 *
 * @author zinho
 */
class Gestor {
    public function TipoArchivos($grupo) {
        $conn=new conexion();
        $sql="select * from config where pertenece=$grupo";
        $res=  mysql_query($sql,$conn->conectar_db(__BASE_DATOS__));
        while($cc=  mysql_fetch_array($res)){
            echo "<option value='".$cc['idconfig']."'>".$cc['item']."</option>";
        }
        
    }
}
