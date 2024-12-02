<?php
    session_start();

    $acciones = isset($_GET['accion'])?$_GET['accion']:2;
    // Verificación de usuario
    if (!isset($_SESSION['tipo_persona']) || !in_array($_SESSION['tipo_persona'], ['administrador', 'usuario'])) {
        header("Location: ../../pages/login.php");
        exit();
    }

    if($acciones<0 || $acciones>1){
        header("Location: ../../index.php");
        exit();
    }

    // Incluye el navbar correspondiente según el tipo de usuario
    if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
        include '../../admin/navbaradmin.php';
    } else {
        include '../../components/navbaruser.php';
    }

    include('../../config/conexion.php');

    $rut = $_SESSION['rut'];
    
    $query_dato = "SELECT * FROM usuario_registrado WHERE rut='$rut'";
    $datos_result = mysqli_query($conexion, $query_dato);
    $result = mysqli_fetch_assoc($datos_result);
    //consultar datos
    $error_message='';
    $nombre = $result['nombre'];
    $apellido = $result['apellido'];
    $correo = $result['correo'];

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perfil Renzomotors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=person" />
    <style>
        body {
            background-color: #e6e6e6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .container-fluid {
            flex: 1;
        }
    </style>
</head>
<body class="pt-5 mt-3" style="display: flex; flex-direction: column; min-height: 100vh;">
    <div class="container-fluid d-flex align-items-center justify-content-center" style="flex: 1;">
        <div class="row m-5 p-3 d-flex justify-content-center border" style="border-radius: 20px; max-width: 800px; width: 100%; background: #f8f9fa;">
            <!-- Fotos de perfil -->
            <div class="col-4 text-center d-flex align-items-center justify-content-center">
                <span class="material-symbols-outlined border" style="background: white; font-size: 10vw; border-radius: 50%; display: inline-block;">
                    person
                </span>
            </div>

            <!-- Información de usuario -->
            <div class="col-8 p-4">
                <div class="text-center mb-4">
                    <h1>Perfil de usuario</h1>
                </div>
                <?php
                    if ($acciones == 1) {
                        include "editar_perfil.php";
                    } else if ($acciones == 0) {
                        echo "
                            <div class='mb-3' style='overflow: hidden; overflow-wrap: break-word; max-width: 300px;word-wrap: break-word;word-break: break-word;'>
                                <p><strong>Nombre:</strong> $nombre</p>
                                <p><strong>Apellido:</strong> $apellido</p>
                                <p><strong>Correo Electrónico:</strong> $correo</p>
                            </div>
                            <!-- Opciones -->
                            <div>
                                <a href='perfil.php?accion=1' class='btn btn-sm' style=' background: #ffc107;'>Editar Datos de Perfil</a>
                            </div>
                        ";
                    }
                ?>
            </div>
        </div>
    </div>
    <?php
            include '../../components/footer.php';
        ?> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
