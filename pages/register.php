<?php
require('../config/conexion.php');
session_start(); // Asegúrate de que la sesión esté iniciada

// Configurar mysqli para lanzar excepciones en caso de errores
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$error_message = ""; // Variable para almacenar el mensaje de error

    // Si se envía el formulario, inserte valores en la base de datos.
    if (isset($_POST['submit'])) {
        $nombre = stripslashes($_POST['nombre']); // removes backslashes
        $nombre = mysqli_real_escape_string($conexion, $nombre); //escapes special characters in a string

        $apellido = stripslashes($_POST['apellido']);
        $apellido = mysqli_real_escape_string($conexion, $apellido);

        $rut = stripslashes($_POST['rut']);
        $rut = mysqli_real_escape_string($conexion, $rut);

        $contrasenia = stripslashes($_POST['contrasenia']);
        $contrasenia = mysqli_real_escape_string($conexion, $contrasenia);

        $correo = stripslashes($_POST['correo']);
        $correo = mysqli_real_escape_string($conexion, $correo);

        //$tipo_persona = mysqli_real_escape_string($conexion, $tipo_persona);
        $contrasenia =  password_hash($contrasenia, PASSWORD_DEFAULT);

        $query = "INSERT into usuario_registrado (nombre, apellido, rut, contrasenia, correo) VALUES ('$nombre', '$apellido', '$rut', '$contrasenia','$correo')";
        
        try {
            $result = mysqli_query($conexion, $query);
    
            if ($result) {
                $_SESSION['success'] = "Registro exitoso. Por favor, inicia sesión.";
                header('Location: login.php'); // Redirigir al login solo si es exitoso
                exit();
            }
        } catch (mysqli_sql_exception $e) {
                if (str_contains($e, 'Correo_unico')) {
                    $error_message = "Correo ya registrado";
                } else {
                $error_message = "Error al registrar el usuario. Por favor, verifica los datos.";
            }
        }
    }
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - Renzo Motors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f0f0f0;">
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 450px;">
            <h3 class="text-center mb-4" style="color: #333;">Registro en Renzo Motors</h3>
            <form action="" method="post" name="register">
                <?php if ($error_message): ?>
                    <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" name="apellido" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="rut" class="form-label">RUN</label>
                    <input type="text" name="rut" class="form-control" pattern="\d{1,2}\.\d{3}\.\d{3}-[\dkK]" required>
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" name="correo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="contrasenia" class="form-label">Contraseña</label>
                    <input type="password" name="contrasenia" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{6,}" required>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" name="submit" class="btn btn-dark">Registrarse</button>
                </div>
                <small class="d-block text-center">
                    ¿Ya tienes cuenta? <a href="./login.php">Iniciar Sesión</a>
                </small>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
