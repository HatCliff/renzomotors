<?php
require('../config/conexion.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['usuario'])) {
    header('Location: /xampp/renzomotors/index.php');
}

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
    $contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);

    $query = "INSERT into usuario_registrado (nombre, apellido, rut, contrasenia, correo) VALUES ('$nombre', '$apellido', '$rut', '$contrasenia','$correo')";

    try {
        $result = mysqli_query($conexion, $query);

        if ($result) {
            $_SESSION['success'] = "Registro exitoso. Por favor, inicia sesión.";

            // Se le asigna un carrito al usuario
            $query_carrito = "INSERT into carrito_usuario (rut_usuario, valor_carrito) VALUES ('$rut', 0)";
            $result_carrito = mysqli_query($conexion, $query_carrito);

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
    <style>
        .full-height {
            min-height: 100vh;
        }

        /* Contenedor que hace que la imagen y el formulario estén juntos como un solo card */
        .card-container {
            display: flex;
            flex-wrap: wrap;
            height: 100%;
        }

        .card-container .image-container {
            background-image: linear-gradient(to bottom, black, transparent), url('../src/images/registro.jpg');
            background-size: cover;
            background-position: center;
            width: 60vh;
            flex: 1 1 50%;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card-container .form-container {
            flex: 1 1 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container .card {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .image-container h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .benefits li {
            margin: 10px 0;
        }
    </style>
</head>

<body style="background-color: #f0f0f0;">
    <div class="container d-flex align-items-center justify-content-center full-height">
        <div class="card-container">
            <div class="image-container">
                <h1>RENZO MOTORS</h1>
                <p class="fs-4">Beneficios al Registrarse:</p>
                <ul class="fs-5">
                    <li>Reserva de Vehículos</li>
                    <li>Compra de Accesorios</li>
                    <li>Centro de ayuda</li>
                    <li>Reseñas</li>
                    <li>Mucho más...</li>
                </ul>
            </div>


            <div class="form-container">
                <div class="card shadow-lg p-4">
                    <h3 class="text-center mb-4" style="color: #333;">Registrate en Renzo Motors</h3>
                    <form action="" method="post" name="register">
                        <?php if ($error_message): ?>
                            <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Juan" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" name="apellido" class="form-control" placeholder="Perez" required>
                        </div>
                        <div class="mb-3">
                            <label for="rut" class="form-label">RUN</label>
                            <input type="text" name="rut" class="form-control" maxlength="12"
                                pattern="\d{1,2}\.\d{3}\.\d{3}-[\dkK]" placeholder="12.3456.789-k" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" name="correo" class="form-control" placeholder="" required>
                        </div>
                        <div class="mb-3">
                            <label for="contrasenia" class="form-label">Contraseña</label>
                            <input type="password" name="contrasenia" class="form-control"
                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{6,}" maxlength="20" required>
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
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>