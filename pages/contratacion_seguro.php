<?php


session_start();
include('../config/conexion.php');



// Verificación de usuario
if (!isset($_SESSION['tipo_persona']) || !in_array($_SESSION['tipo_persona'], ['administrador', 'usuario'])) {
    echo "<script>
        alert('Debe estar logueado para contratar un seguro.');
        window.location.href = '../pages/login.php';
    </script>";
    exit();
}
// Verificar que el ID del seguro esté presente en la URL
if (isset($_GET['id_seguro'])) {
    $id_seguro = $_GET['id_seguro'];

    // Obtener información del seguro seleccionado
    $query = "SELECT s.nombre_seguro, s.descripcion_seguro, s.precio_seguro, proveedor.imagen_proveedor 
              FROM seguro s
              JOIN proveedor ON s.id_proveedor = proveedor.id_proveedor
              WHERE s.id_seguro = ?";
    $stmt = $conexion->prepare($query); //prepara la consulta
    $stmt->bind_param('i', $id_seguro); //enlaza el id_seguro como entero
    $stmt->execute(); //ejecuta la consulta
    $resultado = $stmt->get_result(); //se tiene el resultado

    // Verificar si se encontró el seguro
    if ($row = $resultado->fetch_assoc()) {
        $nombre_seguro = $row['nombre_seguro'];
        $descripcion_seguro = $row['descripcion_seguro'];
        $precio_seguro = $row['precio_seguro'];
        $imagen_proveedor = $row['imagen_proveedor'];
    } else {
        echo "<script>alert('Seguro no encontrado.');</script>";
        exit();
    }
} else {
    echo "<script>alert('No se ha seleccionado un seguro.');</script>";
    header("Location: seguro.php");
    exit();
}


// Cargar los tipos de vehículos, marcas y vehículos
$render_tipo_vehiculo = '';
$tipos_vehiculo = mysqli_query($conexion, "SELECT id_tipo_vehiculo, nombre_tipo_vehiculo FROM tipo_vehiculo");
while ($tipo = mysqli_fetch_assoc($tipos_vehiculo)) {
    $render_tipo_vehiculo .= "<option value='{$tipo['id_tipo_vehiculo']}'>{$tipo['nombre_tipo_vehiculo']}</option>";
}

$render_marca = '';
$marcas = mysqli_query($conexion, "SELECT id_marca, nombre_marca FROM marca");
while ($marca = mysqli_fetch_assoc($marcas)) {
    $render_marca .= "<option value='{$marca['id_marca']}'>{$marca['nombre_marca']}</option>";
}

$render_vehiculo = '';
$vehiculos = mysqli_query($conexion, "SELECT id_vehiculo, nombre_modelo FROM vehiculo");
while ($vehiculo = mysqli_fetch_assoc($vehiculos)) {
    $render_vehiculo .= "<option value='{$vehiculo['id_vehiculo']}'>{$vehiculo['nombre_modelo']}</option>";
}

$render_anio = '';
$anios = mysqli_query($conexion, "SELECT id_anio, anio FROM anio order by anio asc");
while ($anio = mysqli_fetch_assoc($anios)) {
    $render_anio .= "<option value='{$anio['id_anio']}'>{$anio['anio']}</option>";
}
/*
$render_anio = '';
$query_anio = "SELECT DISTINCT anio FROM anio ORDER BY anio ASC"; // Cambia "anios" por el nombre real de tu tabla

$result_anio = $conexion->query($query_anio);

if ($result_anio && $result_anio->num_rows > 0) {
    while ($row = $result_anio->fetch_assoc()) {
        $render_anio .= "<option value='{$row['anio']}'>{$row['anio']}</option>";
    }
}*/



// Recibir los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rut_usuario = $_SESSION['rut']; // Supuesto: El RUT está guardado en la sesión
    $id_seguro = intval($_GET['id_seguro']); // Sanitización básica
    $id_tipo_vehiculo = intval($_POST['id_tipo_vehiculo']);
    $id_marca = intval($_POST['id_marca']);
    $id_vehiculo = intval($_POST['id_vehiculo']);
    $telefono = intval($_POST['telefono']);
    $patente = mysqli_real_escape_string($conexion, $_POST['patente']);
    $numero_motor = mysqli_real_escape_string($conexion, $_POST['numero_motor']);
    $numero_chasis = mysqli_real_escape_string($conexion, $_POST['numero_chasis']);
    $id_anio = intval($_POST['id_anio']); // Captura el ID del año
    $fecha_inicio_con = mysqli_real_escape_string($conexion, $_POST['fecha_inicio_con']);

    // Validar fecha de inicio
    if (!strtotime($fecha_inicio_con)) {
        die("Formato de fecha inválido");
    }
    $fecha_inicio_con = date('Y-m-d', strtotime($fecha_inicio_con));
    // Calcular la fecha de término (un año después de la fecha de inicio)
    $fecha_termino_contra = date('Y-m-d', strtotime('+1 year', strtotime($fecha_inicio_con)));

    

    // Insertar en la tabla `usuario_seguro`
    $query = "
        INSERT INTO usuario_seguro (
            id_seguro, rut_usuario, id_tipo_vehiculo, id_marca, id_vehiculo, telefono, 
            patente, numero_motor, numero_chasis, fecha_inicio_con, fecha_termino_cont, id_anio
        ) VALUES (
            $id_seguro, '$rut_usuario', $id_tipo_vehiculo, '$id_marca', $id_vehiculo, $telefono, 
            '$patente', '$numero_motor', '$numero_chasis', '$fecha_inicio_con', '$fecha_termino_contra', $id_anio)";

    // Ejecutar la consulta
    $result = mysqli_query($conexion, $query);

    if ($result) {
        echo "Seguro contratado exitosamente";
    } else {
        echo "Error al contratar el seguro: " . mysqli_error($conexion);
    }
}



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Contración seguro</title>
    <style>
        body {
            background-color: #f8f9fa;
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
    <div class="container mt-2">
        <div class="form-container">
            <form action='' method="POST" enctype="multipart/form-data">
                <h4 class="mb-2">Contratación de seguro</h4>
                <!-- Selector para elegir si es para el usuario actual o para un tercero 
                <div class="form-group mb-3">
                    <label class="form-label">¿La reserva es para usted o para un tercero?</label>
                    <select class="form-select" id="reservation_for" required onchange="togglePersonalInfo()">
                        <option value="self">Para mí</option>
                        <option value="third_party">Para un tercero</option>
                    </select>
                </div>
                -->

                <!-- Mostrar la información del seguro -->
                <div class="mb-3">
                    <label for="nombre_seguro" class="form-label">Seguro Seleccionado</label>
                    <input type="text" class="form-control" id="nombre_seguro" name="nombre_seguro"
                        value="<?php echo $nombre_seguro; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="descripcion_seguro" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion_seguro" name="descripcion_seguro" rows="3"
                        readonly><?php echo $descripcion_seguro; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="precio_seguro" class="form-label ">Precio</label>
                    <input type="text" class="form-control" id="precio_seguro" name="precio_seguro"
                        value="<?php echo number_format($precio_seguro, 0, ',', '.'); ?> CLP" readonly>
                </div>
                <div class="mb-3 d-flex justify-content-center align-items-center">
                    <label for="imagen_proveedor" class="form-label "></label>
                    <img src="../admin/mantenedores/proveedores/<?php echo $imagen_proveedor; ?>"
                        alt="Logo del proveedor" style="max-height: 100px; object-fit: contain;">
                </div>

                <!-- Campos de información personal -->
                <div id="personal_info">
                    <div class="form-group mb-3">
                        <label for="rut" class="form-label">Rut</label>
                        <input type="text" name="rut" id="rut" value="<?php echo $_SESSION['rut'] ?? ''; ?>"
                            class="form-control" disabled>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" id="nombre"
                                value="<?php echo $_SESSION['nombre'] ?? ''; ?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" name="apellido" class="form-control" id="apellido"
                                value="<?php echo $_SESSION['apellido'] ?? ''; ?>" disabled>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control" id="correo"
                                value="<?php echo $_SESSION['correo'] ?? ''; ?>" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Número Telefónico</label>
                            <input type="number" name="telefono" class="form-control" id="telefono" maxlength="11"
                                placeholder="569..." required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <!-- Columna para el selector -->
                        <div class="col-md-6">
                            <label for="tipo_vehiculo" class="form-label">Tipo de Vehículo</label>
                            <select class="form-select" name="id_tipo_vehiculo" id="tipo_vehiculo"
                                aria-label="Default select example" required>
                                <option value="" selected disabled>Seleccionar</option>
                                <?php echo $render_tipo_vehiculo; ?>

                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="patente" class="form-label">Patente</label>
                            <input type="text" name="patente" class="form-control" id="patente" maxlength="6"
                                placeholder="BBCC21" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Columna para el selector -->
                        <div class="col-md-6">
                            <label for="marca" class="form-label">Marca</label>
                            <select class="form-select" name="id_marca" id="marca" aria-label="Default select example"
                                required>
                                <option value="" selected disabled>Seleccionar</option>
                                <?php echo $render_marca; ?>
                            </select>
                        </div>
                        <!-- Columna para el campo de texto -->
                        <div class="col-md-6">
                            <label for="modelo" class="form-label">Modelo</label>
                            <select class="form-select" name="id_vehiculo" id="modelo"
                                aria-label="Default select example" required>
                                <option value="" selected disabled>Seleccionar</option>
                                <?php echo $render_vehiculo; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <!-- Columna para el selector -->
                        <div class="form-group mb-3">
                            <label for="numero_chasis" class="form-label">Número Chasis</label>
                            <input type="text" name="numero_chasis" class="form-control" id="numero_chasis"
                                maxlength="14" required>
                        </div>

                        <!-- Columna para el campo de texto -->

                        <div class="form-group mb-3">
                            <label for="numero_motor" class="form-label">Número Motor</label>
                            <input type="text" name="numero_motor" class="form-control" id="numero_motor" maxlength="14"
                                required>
                        </div>

                    </div>

                    <div class="form-group mb-3">
                        <label for="anio" class="form-label">Año</label>
                        <select class="form-select" name="id_anio" id="id_anio" required>
                            <option value="" selected disabled>seleccionar Año</option>
                            <?php echo $render_anio; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="datepicker">Fecha de inicio:</label>
                        <input type="date" name="fecha_inicio_con" class="form-control" id="datepicker_uno" required>
                    </div>

                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-custom">Pagar Seguro</button>
                </div>
            </form>




        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

    <script>
        // Datos del usuario para autocompletar
        const userData = {
            nombre: "<?php echo $_SESSION['nombre'] ?? ''; ?>",
            apellido: "<?php echo $_SESSION['apellido'] ?? ''; ?>",
            correo: "<?php echo $_SESSION['correo'] ?? ''; ?>",
            rut: "<?php echo $_SESSION['rut'] ?? ''; ?>"
        };

        // Autocompletar datos del usuario en los campos correspondientes
        document.addEventListener('DOMContentLoaded', () => {
            const nombreField = document.getElementById('nombre');
            const apellidoField = document.getElementById('apellido');
            const correoField = document.getElementById('correo');
            const rutField = document.getElementById('rut');

            if (nombreField) nombreField.value = userData.nombre;
            if (apellidoField) apellidoField.value = userData.apellido;
            if (correoField) correoField.value = userData.correo;
            if (rutField) rutField.value = userData.rut;
        });

        $(function () {
            const today = new Date(); // Obtener la fecha actual

            // Configuración de la fecha de inicio
            $("#datepicker_uno").datepicker({
                dateFormat: "yy-mm-dd", // Formato de fecha
                minDate: today, // Establece hoy como fecha mínima
                onSelect: function (dateText) {
                    const startDate = new Date(dateText);
                    startDate.setDate(startDate.getDate() + 1); // Establece el día siguiente como fecha mínima para la fecha de término
                    const maxDate = new Date(dateText);
                    maxDate.setFullYear(maxDate.getFullYear() + 1); // Establece un año después como fecha máxima
                    // El selector de fecha de término se configurará automáticamente según la fecha de inicio
                }
            });
        });



    </script>



</body>

</html>