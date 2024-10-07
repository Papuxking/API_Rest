<?php
include_once("conexion.php");

class crudI
{

    public static function guardarEstudiante()
    {

        $objetoconexion = new conexion();
        $conn = $objetoconexion->conectar();

        $cedula = $_POST['cedula'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];

        $guardarEstudiante = "INSERT INTO estudiantes values('$cedula','$nombres','$apellidos','$direccion','$telefono')";

        $result = $conn->prepare($guardarEstudiante);
        $result->execute();

        //print_r("Se inserto el estudiante correctamente");

        $dataJson = json_encode("Se inserto el estudiante correctamente");
        print_r($dataJson);


    }
}

?>