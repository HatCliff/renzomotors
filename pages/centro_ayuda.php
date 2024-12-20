<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../config/conexion.php');

if (!isset($_SESSION['tipo_persona']) || !in_array($_SESSION['tipo_persona'], ['usuario'])) {
    echo "<script>
    window.location.href = '../pages/login.php';
    </script>";
    exit();
}
$rut = $_SESSION['rut'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asunto_solicitud = $_POST['asunto_solicitud'];
    $descripcion_solicitud = $_POST['descripcion_solicitud'];
    $tipo_solicitud = $_POST['tipo_solicitud'];


    // Validar campos obligatorios
    if (empty($asunto_solicitud) || empty($descripcion_solicitud) || empty($tipo_solicitud)) {
        echo "Faltan datos por ingresar la solicitud.";
        exit;
    }

    // Validar tipo de atención
    $tipos_validos = ['comentario', 'sugerencia', 'reclamo', 'duda'];
    if (!in_array($tipo_solicitud, $tipos_validos)) {
        echo "El tipo de atención no es válido.";
        exit;
    }

    // Validar malas palabras desde la base de datos
    $consulta_palabra = "SELECT palabra FROM palabra_prohibida";
    $resultado_palabras = mysqli_query($conexion, $consulta_palabra);

    if ($resultado_palabras) {
        while ($fila = mysqli_fetch_assoc($resultado_palabras)) {
            $palabra_prohibida = $fila['palabra'];
            // Validar si alguna palabra prohibida está en el asunto o descripción
            if (stripos($asunto_solicitud, $palabra_prohibida) !== false || stripos($descripcion_solicitud, $palabra_prohibida) !== false) {
                echo "Tu solicitud contiene palabras inapropiadas. Por favor, corrige el texto.";
                exit;
            }
        }
    } else {
        echo "Error al consultar palabras prohibidas: " . mysqli_error($conexion);
        exit;
    }


    $query = "INSERT INTO solicitud_ayuda (rut, asunto_solicitud, descripcion_solicitud, tipo_solicitud) 
                VALUES ('$rut', '$asunto_solicitud', '$descripcion_solicitud', '$tipo_solicitud')";

    try {
        $resultado = mysqli_query($conexion, $query);

        if ($resultado) {
            header("Location: centro_ayuda.php");
        } else {
            echo "Error en el registro de ayuda: " . mysqli_error($conexion);
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }

}


// Incluye el navbar correspondiente según el tipo de usuario
if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
    // Usuario es administrador, incluye el navbar de administrador
    include '../admin/navbaradmin.php';
} else {
    // Usuario es normal, incluye el navbar de usuario
    include '../components/navbaruser.php';
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <title>Centro de Ayuda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=chevron_left" />
    

    <style>
        body {
            background-color: #E6E6E6;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            margin: auto;
        }

        .btn-custom {
            background-color: #448e42;
            color: #ffffff;
            font-weight: bold;
            border-radius: 5px;

        }

        .btn-custom:hover {
            background-color: #366c35;
        }
    </style>
</head>

<body class="mt-5 pt-5">
    <div class="container mt-5">
        <div class="form-container">
            <div class="row align-items-center mb-4">
                <div class="col-auto">
                    <a href="../index.php" class="btn btn-light">
                        <span class="material-symbols-outlined">
                            chevron_left
                        </span>
                    </a>
                </div>

                <!-- Título centrado -->
                <div class="col text-center">
                    <h4 class="m-0">Centro de Ayuda</h4>
                </div>
            </div>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="tipo_solicitud">Tipo de Atención</label>
                    <select class="form-control" id="tipo_solicitud" name="tipo_solicitud" required>
                        <option value="">Seleccione</option>
                        <option value="comentario">Comentario</option>
                        <option value="sugerencia">Sugerencia</option>
                        <option value="reclamo">Reclamo</option>
                        <option value="duda">Duda</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="asunto_solicitud">Asunto</label>
                    <input type="text" class="form-control" id="asunto_solicitud" name="asunto_solicitud" maxlength="40"
                        required>
                </div>
                <div class="mb-3">
                    <label for="descripcion_solicitud">Descripción</label>
                    <textarea class="form-control" id="descripcion_solicitud" name="descripcion_solicitud"
                        maxlength="200" required></textarea>
                </div>

                <div class="d-flex justify-content-center  mt-4">
                    <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
                </div>

                <div class="d-flex justify-content-center  mt-2">
                    <a class="btn btn-secondary" href='<?php echo $carpetaMain; ?>index.php'>
                        Volver
                    </a>
                </div>


            </form>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>