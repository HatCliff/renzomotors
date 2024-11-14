<?php
session_start();
include('../../config/conexion.php');

// Verificación de entrada válida
if (!isset($_SESSION['rut']) || !isset($_POST['id_vehiculo']) || !isset($_POST['action'])) {
    echo json_encode(['success' => false, 'error' => 'Parámetros no válidos']);
    exit;
}

$id_usuario = $_SESSION['rut'];
$id_vehiculo = $_POST['id_vehiculo'];
$action = $_POST['action'];

// Según la acción, añade o elimina el favorito
if ($action === 'add') {
    $query = "INSERT INTO favoritos (id_usuario, id_vehiculo) VALUES ('$id_usuario', '$id_vehiculo')";
    
} elseif ($action === 'remove') {
    $query = "DELETE FROM favoritos WHERE id_usuario = '$id_usuario' AND id_vehiculo = '$id_vehiculo'";
} else {
    echo json_encode(['success' => false, 'error' => 'Acción no válida']);
    exit;
}

$result = mysqli_query($conexion, $query);
if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => mysqli_error($conexion)]);
}
?>
