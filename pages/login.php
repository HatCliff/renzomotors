<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['usuario'])) {
    header('Location: /xampp/renzomotors/index.php');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renzo Motors - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="logo.png" type="image/png">
    <style>
        .full-height {
            min-height: 100vh;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            height: 100%;
        }

        .card-container .image-container {
            background-image: linear-gradient(to bottom, black, transparent), url('../src/images/login.jpg');
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
                <p class="fs-4">Bienvenido a la experiencia Renzo Motors</p>
                <ul class="fs-5">
                    <li>Reservas, accesorios y seguros...</li>
                </ul>
            </div>

            <div class="form-container">
                <div class="card shadow-lg p-4">
                    <h3 class="text-center mb-4" style="color: #333;">Iniciar Sesión en Renzo Motors</h3>
                    <form action="./../auth/login.php" method="post">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger text-center"><?php echo $_SESSION['error']; ?></div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control" placeholder="Escribe aquí tu correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="contrasenia" class="form-label">Contraseña</label>
                            <input type="password" name="contrasenia" class="form-control" placeholder="Contraseña" required>
                        </div>
                        <small class="d-block text-center mb-3">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalId">¿Olvidaste tu contraseña?</a>
                        </small>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark">Iniciar Sesión</button>
                        </div>
                        <small class="d-block text-center mt-3">
                            ¿No tienes cuenta? <a href="./register.php">Registrarse</a>
                        </small>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Recuperación -->
    <div class="modal fade" id="modalId" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restablecer Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="./recover.php" method="post">
                    <div class="modal-body">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control" required>
                        
                        <label for="nueva_contrasena" class="form-label">Nueva Contraseña:</label>
                        <input type="password" name="nueva_contrasena" class="form-control"
                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{6,}" maxlength="20" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Generar Nueva Contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
