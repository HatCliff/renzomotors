<?php 
require './../components/validationUI.php';
session_start();
    if(isset($_SESSION['usuario'])){
         header('Location: /xampp/renzomotors/');
    }

    if(isset($_SESSION['error'])){
        error($_SESSION['error_code'], $_SESSION['error']);
        //echo "<div class='mx-auto fcol-3 fixed-top alert alert-danger' role='alert'>Error ". $_SESSION['error_code'] . ": ". $_SESSION['error'] . "</div>";
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renzo Motors - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="logo.png" type="image/png">
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh; background-color: #f0f0f0;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4" style="color: #333;">Renzo Motors</h2>
        <form action="./../auth/login.php" method="post">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <div class="input-group">
                    <span class="input-group-text" style="background-color: #D9D9D9;"><img src="./../src/icons/user.svg" alt="Usuario" width="15px"></span>
                    <input type="email" name="correo" class="form-control" placeholder="Escribe aquí tu correo" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="contrasenia" class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text" style="background-color: #D9D9D9;"><img src="./../src/icons/lock.svg" alt="Contraseña" width="15px"></span>
                    <input type="password" name="contrasenia" class="form-control" placeholder="Contraseña" required>
                </div>
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
    <!-- Modal de Recuperación -->
    <div class="modal fade" id="modalId" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restablecer Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/recovery.php" method="post">
                    <div class="modal-body">
                        <label for="recoveryMail" class="form-label">Correo Electrónico</label>
                        <input type="email" name="recoveryMail" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Restablecer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

