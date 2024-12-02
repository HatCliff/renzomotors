<?php
include('../../config/conexion.php');
include('./../../components/validationUI.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rut_conductor = $_POST['rut_conductor'];
    $correo_conductor = $_POST['correo_conductor'];
    $fecha_prueba = $_POST['fecha_prueba'];
    $hora_prueba = $_POST['hora_prueba'];

    // Consulta para eliminar la prueba de manejo
    $delete_query = "DELETE FROM agenda_prueba
                     WHERE rut_conductor = ? AND correo_conductor = ? AND fecha_prueba = ? AND hora_prueba = ?";

    $stmt = $conexion->prepare($delete_query);
    $stmt->bind_param('ssss', $rut_conductor, $correo_conductor, $fecha_prueba, $hora_prueba);

    if ($stmt->execute()) {
        success(true,"Prueba de manejo cancelada con éxito.");
    } else {
        success(false,"Error al cancelar la prueba de manejo.");
    }
}
?>
