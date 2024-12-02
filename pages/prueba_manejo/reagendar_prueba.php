<?php
include('../../config/conexion.php');
require('../../components/validationUI.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rut_conductor = $_POST['rut_conductor'];
    $correo_conductor = $_POST['correo_conductor'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $fecha_prueba = $_POST['fecha_prueba'];
    $hora_prueba = $_POST['hora_prueba'];

    // Actualizamos la fecha y hora en la base de datos usando una combinación de RUT, correo, fecha y hora
    $update_query = "UPDATE agenda_prueba 
                     SET fecha_prueba = ?, hora_prueba = ? 
                     WHERE rut_conductor = ? 
                     AND correo_conductor = ? 
                     AND fecha_prueba = ? 
                     AND hora_prueba = ?";
    
    $stmt = $conexion->prepare($update_query);
    $stmt->bind_param('ssssss', $fecha, $hora, $rut_conductor, $correo_conductor, $fecha_prueba, $hora_prueba);

    if ($stmt->execute()) {
        success(true,'Prueba reagendada con éxito.');
    } else {
        success(false,'Error: No se ha podido reagendar la prueba, intenta más tarde.');
    }
}
?>
