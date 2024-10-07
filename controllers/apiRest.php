<?php
include '../models/acceder.php';
include '../models/guardar.php';
include '../models/borrar.php';
include '../models/editar.php';
include '../models/buscar.php';

$opc = $_SERVER['REQUEST_METHOD'];

switch ($opc) {
    case 'GET':
        if (isset($_GET['cedula'])) {
            crudBuscar::buscarEstudiante($_GET['cedula']);
        } else {
            crudS::seleccionarEstudiantes();
        }
        break;

    case 'POST':
        crudI::guardarEstudiante();
        break;

    case 'DELETE':
        if (isset($_GET['cedula'])) {
            crudE::eliminarEstudiante();
        } else {
            echo json_encode(['success' => false, 'errorMsg' => 'No se envió la cédula']);
        }
        break;

        case 'PUT':
            if (isset($_GET['cedula'])) {
            crudU::modificarEstudiante($_GET['cedula']);
        }else {
            echo json_encode(['success' => false, 'errorMsg' => 'No se envió la cédula']);
        }
            break;

        

    default:
        echo json_encode(['success' => false, 'errorMsg' => 'Método no soportado']);
        break;
}
?>
