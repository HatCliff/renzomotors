<?php 
session_start();
if(isset($_SESSION['usuario'])){
    header('Location: /pages/dashboard');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RenzoMotors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="logo.png" type="image/png">
</head>
<body style='height:100vh;' class="d-flex align-items-center justify-content-center">
    <div class="mx-auto" style="width: auto;">
        <div class="py-5 px-5">
        <div class="mb-3 border py-5 px-5">
            <form action="./../auth/login.php" method="post">
                    
                <h2 class="text-center">Renzo Motors</h2>
                <h5>Correo Electrónico</h5>
                <div class="input-group">
                    <span style='background-color:#D9D9D9;' class="input-group-text py-3 px-3"><label for="" class="form-label">
                        <img src="./../src/icons/user.svg" alt="Usuario" width="10px">
                    </label></span>
                    <input
                        type="text"
                        class="form-control"
                        name="email"
                        id=""
                        aria-describedby="helpId"
                        placeholder="Escribe aquí tu correo"
                    />
                </div>
                <h5>Contraseña</h5>
                <div class="input-group">    
                    <span style='background-color:#D9D9D9;' class="input-group-text py-3 px-3"><label for="" class="form-label"><img src="./../src/icons/lock.svg" alt="Contraseña" width="10px"></label></span>
                        <input
                            type="password"
                            class="form-control"
                            name="password"
                            id=""
                            aria-describedby="helpId"
                            placeholder="Contraseña"
                        />
                </div>
                <small id="helpId" class="form-text text-muted">¿Olvidaste la contraseña? <a href="/pages/recover.php" class="">Restablecela</a></small>
                <div class="d-grid gap-2 mt-3">
                    <input type="submit" value="Iniciar Sesión" class="btn btn-primary" style='background-color:#D9D9D9; color:black; border:2px;'>
                </div>    
            </div>
        </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
