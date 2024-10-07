<?php

//include cuando se requiere que permanezca conectado 
//include_once cuando se hace la conexion y se cierra, al recargar la pagina se vuelve a conectar

include_once("conexion.php");

class crudS{

    
    public static function seleccionarEstudiantes()
{

    $objetoconexion = new conexion();
    $conn=$objetoconexion->conectar();
    $selectEstudiantes = "SELECT * FROM estudiantes";
    $result = $conn->prepare($selectEstudiantes);
    $result->execute();
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    $dataJson = json_encode($data);
    //print_r($data);
    print_r($dataJson);

}
}



?>