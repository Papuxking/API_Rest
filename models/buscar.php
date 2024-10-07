<?php
include_once 'conexion.php';

class crudBuscar
{
    public static function buscarEstudiante($cedula)
    {
        $objetoConexion = new conexion();
        $conn = $objetoConexion->conectar();

        
        $buscarEstudiante = "SELECT * FROM estudiantes WHERE cedula='$cedula'";
        $result = $conn->prepare($buscarEstudiante);
        $result->execute();

        

        if ($result->rowCount() > 0) {
            $estudiante = $result->fetch(PDO::FETCH_ASSOC);
            $dataJson = json_encode($estudiante);
        } else {
            $dataJson = json_encode(['mensaje' => 'Estudiante no encontrado']);
        }

        print_r($dataJson);
    }
}
