<?php
include_once 'conexion.php';

class crudU
{
    public static function modificarEstudiante($cedula)
    {
        $objetoConexion = new conexion();
        $conn = $objetoConexion->conectar();

        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $nombres = $data['nombres'];
        $apellidos = $data['apellidos'];
        $direccion = $data['direccion'];
        $telefono = $data['telefono'];

        $modificarEstudiante = "UPDATE estudiantes SET nombres='$nombres',apellidos='$apellidos',direccion='$direccion',telefono='$telefono' WHERE cedula='$cedula'";
        $result = $conn->prepare($modificarEstudiante);
        $result->execute();


        $dataJson = json_encode($result);

        print_r($dataJson);
    }
}
