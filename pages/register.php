<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php

        require('../config/conexion.php');
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
                $result = mysqli_query($conexion, $query);

                

                if($result){
                    $_SESSION['success'] = "Registro exitoso. Por favor, inicia sesión.";
                    header('Location: login.php'); // Redirigir al login
                    exit();
                } else {
                    $_SESSION['error'] = "Error al registrar el usuario.";
                    $_SESSION['error_code'] = "Registro";
                    header('Location: register.php');
                    exit();
                }
            }else{
                
        ?>

            <div class="container px-5 ">

                <div class="row justify-content-sm-center">

                    <div class="col-lg-6 col-sm-12 px-5 mt-2">
                        <div class="card px-5 mt-4">
                            <div class="card-body">
                                <form action=""  name="register"  method="post">
                                    <div class="container d-flex my-3">
                                        <div class="d-flex justify-content-center align-items-center w-100">
                                            <h5 class="mb-3">Registro</h5>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Juan" required>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                                <label for="apellido" class="form-label">Apellido</label>
                                                <input type="text" name="apellido" class="form-control" id="apellido" placeholder="Perez" required>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="rut" class="form-label">RUN</label>
                                            <input type="text" name="rut" maxlength="12" size="12" pattern="\d{1,2}\.\d{3}\.\d{3}-[\dkK]" placeholder="12.345.125-5" class="form-control"  required/>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="inputEmail4" class="form-label">Correo</label>
                                            <input type="email" name="correo" class="form-control" id="inputEmail4" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|cl)$" title="El correo debe contener un arroba (@) y terminar con .com o .cl"  required>
                                        </div>
                                        
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                        <label for="inputPassword4" class="form-label">Contraseña</label>
                                        <input type="password" name="contrasenia" class="form-control" id="inputPassword4" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{6,}" title="La contraseña debe tener al menos 6 caracteres, incluyendo una letra mayúscula, una letra minúscula, un número y un carácter especial." required>
                                    </div>

                                    <div class="col-12 d-flex justify-content-center mb-2 mt-4">
                                        <button type="submit" name="submit" class="btn btn-dark">Registrarse</button>
                                    </div>

                                    <p class="mt-3 d-flex justify-content-center text-center">¿Tienes una cuenta?
                                        <a class="ml-1" href="login.php"> Inicia sesión</a>
                                    </p>

                                </form>
                            </div>
                        </div>



                    </div>

                </div>
            </div>
        <?php 
    }
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>