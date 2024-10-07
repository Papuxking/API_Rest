<?php
include_once("conexion.php");

class crudE {
    public static function eliminarEstudiante() {
        $objetoconexion = new conexion();
        $conn = $objetoconexion->conectar();
        $cedula = $_GET['cedula'];

        // Usar consultas preparadas para evitar inyecciones SQL
        $borrarEstudiante = $conn->prepare("DELETE FROM estudiantes WHERE cedula = :cedula");
        $borrarEstudiante->bindParam(':cedula', $cedula, PDO::PARAM_STR);

        if ($borrarEstudiante->execute()) {
            $response = array('success' => true, 'message' => 'Se borró el estudiante correctamente');
        } else {
            $response = array('success' => false, 'errorMsg' => 'No se pudo borrar el estudiante');
        }

        // Enviar respuesta JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>
