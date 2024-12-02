<?php
require './../config/conexion.php';
require './../components/validationUI.php';
// Verificar si se recibió un correo y una nueva contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? null;
    $nueva_contrasena = $_POST['nueva_contrasena'] ?? null;

    if (!$correo || !$nueva_contrasena) {
        echo "Por favor, proporciona un correo y una nueva contraseña.";
        exit;
    }

    // Buscar el usuario por correo
    $query_buscar = "SELECT * FROM usuario_registrado WHERE correo = ?";
    $stmt_buscar = $conexion->prepare($query_buscar);
    $stmt_buscar->bind_param("s", $correo);
    $stmt_buscar->execute();
    $resultado = $stmt_buscar->get_result();

    if ($resultado->num_rows > 0) {
        // Usuario encontrado, actualizar contraseña
        $hash_contrasena = password_hash($nueva_contrasena, PASSWORD_BCRYPT);

        $query_actualizar = "UPDATE usuario_registrado SET contrasenia = ? WHERE correo = ?";
        $stmt_actualizar = $conexion->prepare($query_actualizar);
        $stmt_actualizar->bind_param("ss", $hash_contrasena, $correo);

        if ($stmt_actualizar->execute()) {
            success(true,"Contraseña actualizada correctamente.");
        } else {
            success(false,"Error al actualizar la contraseña: " . $stmt_actualizar->error);
        }

        $stmt_actualizar->close();
    } else {
        success(false,"No se encontró un usuario con ese correo.");
    }

    $stmt_buscar->close();
} else {
    success(false,"Método no permitido. Usa POST.");
}

$conexion->close();

?>