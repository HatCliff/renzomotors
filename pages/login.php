<?php 
session_start();
    if(isset($_SESSION['usuario'])){
    //    header('Location: /pages/dashboard');
    }

    if(isset($_SESSION['error'])){
        echo "<div class='mx-auto fcol-3 fixed-top alert alert-danger' role='alert'>Error ". $_SESSION['error_code'] . ": ". $_SESSION['error'] . "</div>";
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
        <div class="mb-3 border py-5 px-5" style="background-color:#f8f8f8; padding: 5vh 5vw !important;">
            <form action="./../auth/login.php" method="post">
                        
                <h2 class="text-center">Renzo Motors</h2>
                <h5>Correo Electrónico</h5>
                <div class="input-group">
                    <span style='background-color:#D9D9D9;' class="input-group-text py-3 px-3"><label for="" class="form-label">
                        <img src="./../src/icons/user.svg" alt="Usuario" width="10px">
                    </label></span>
                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        id=""
                        aria-describedby="helpId"
                        placeholder="Escribe aquí tu correo"
                        required 
                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                        title="El formato del correo debe ser nombre@email.com"
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
                            required
                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{6,}"
                            title="La contraseña debe tener al menos 6 caracteres, incluyendo una letra mayúscula, una letra minúscula, un número y un carácter especial."

                        />
                </div>
                <small id="helpId" class="form-text text-muted">¿Olvidaste la contraseña? <a data-bs-toggle="modal" data-bs-target="#modalId" class="">Restablecela</a></small>
                <small id="helpId" class="form-text text-muted">¿No tienes cuenta? <a href="./registrarse" class="">Registrarse</a></small>
                <div class="d-grid gap-2 mt-3">
                    <input type="submit" value="Iniciar Sesión" class="btn btn-primary" style='background-color:#D9D9D9; color:black; border:2px;'>
                </div>    
                </form>
                <div class="d-flex align-items-center">
                    
                    <div
                        class="modal fade"
                        id="modalId"
                        tabindex="-1"
                        data-bs-backdrop="static"
                        data-bs-keyboard="false"
                        
                        role="dialog"
                        aria-labelledby="modalTitleId"
                        aria-hidden="true"
                    >
                        <div
                            class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                            role="document"
                        >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalTitleId">
                                        Restablecer contraseña.
                                    </h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <form action="/recovery.php" method="post">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Correo electrónico</label>
                                            <input
                                                type="email"
                                                class="form-control"
                                                name="recoveryMail"
                                                id=""
                                                aria-describedby="helpId"
                                                placeholder=""
                                                required
                                                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                            />
                                    </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary">Cerrar</button>
                                        <input type="submit" value="Restablecer contraseña" class="btn btn-primary">
                                    </div>
                            </div>
                        </div>
                    </div>
                    
                    <script>
                        const myModal = new bootstrap.Modal(
                            document.getElementById("modalId"),
                            options,
                        );
                    </script>
                </div>
            </div>
        </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
