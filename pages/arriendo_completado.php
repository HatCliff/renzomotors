<?php
session_start();
include('../config/conexion.php');

// Verificación de usuario
if (!isset($_SESSION['tipo_persona']) || !in_array($_SESSION['tipo_persona'], ['administrador', 'usuario'])) {
    header("Location: ../pages/login.php");
    exit();
}
$render = '45000';
$garantia = '1200000';

// Obtenemos los datos del vehículo
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $sucursal = $_GET['sucursal'];
    $precio = 0;

    $modelo_query = "SELECT nombre_modelo, precio_modelo FROM vehiculo WHERE id_vehiculo = '$id'";
    $modelos = mysqli_query($conexion, $modelo_query);
    $render_color = '';
    $colores = mysqli_query($conexion, "SELECT * FROM color c
                                        JOIN color_vehiculo cv ON c.id_color = cv.id_color
                                        WHERE cv.id_vehiculo = '$id'");
    while ($color = mysqli_fetch_assoc($colores)) {
        $render_color .= "
        <div class='form-check form-check-inline'>
            <input required class='form-check-input' type='radio' name='color' value='{$color['id_color']}' id='color_{$color['id_color']}'>
            <label class='form-check-label' for='color_{$color['id_color']}' style='background-color: {$color['codigo_color']}; width: 30px; height: 30px; border-radius: 50%; border: 2px solid #ccc;'></label>
        </div>
        ";
    }
}

if ($_SESSION['tipo_persona'] === 'administrador') {
    // include '../admin/navbaradmin.php';
} else {
    include '../components/navbaruser.php';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_vehiculo = $_GET['id']; // Obtener id_vehiculo desde POST
    $id_sucursal =$_GET['sucursal'];  // Obtener id_sucursal desde POST
    $rut= $_POST['rut'];
    $nombre=$_POST['nombre'];
    $correo=$_POST['correo'];
    $telefono=$_POST['telefono'];
    $fecha_inicio=$_POST['fecha_i'];
    $fecha_termino=$_POST['fecha_t'];

    $fecha_envio = date('Y-m-d'); // Obtener fecha desde POST
    $hora_envio = $_POST['hora_envio'];  // Obtener hora desde POST

    $query = "INSERT INTO arriendo_vehiculo (id_vehiculo, rut, fecha_arriendo, hora_arriendo) 
    VALUES ('$id_vehiculo','$rut','$fecha_envio','$hora_envio')";

    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $num_arriendo_vehiculo = mysqli_insert_id($conexion);
    
        $query = "INSERT INTO registro_arriendo(id_registro_arriendo, nombre_arrendedor, correo_arrendedor, telefono_arrendedor, sucursal_arriendo, rut,
                    metodo_pago, valor, id_vehiculo, arriendo_concretada, fecha_inicio, fecha_termino, garantia) 
        VALUES ('$num_arriendo_vehiculo','$nombre', '$correo','$telefono','$id_sucursal', '$rut', 'credito', '$render','$id_vehiculo', 0,'$fecha_inicio','$fecha_termino','$garantia')";
        $resultado = mysqli_query($conexion, $query);

        header("Location: http://localhost/xampp/renzomotors/utils/correo_arriendo.php");
        exit();

    } else {
        success(false, "Error en la reserva" . mysqli_error($conexion));
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

    <!-- Incluir Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        const userData = {
            nombre: "<?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : ''; ?>",
            correo: "<?php echo isset($_SESSION['correo']) ? $_SESSION['correo'] : ''; ?>",
            rut: "<?php echo isset($_SESSION['rut']) ? $_SESSION['rut'] : ''; ?>"
        };

        function autoCompletarDatos() {
            // Autocompletar los campos con los datos de sesión si están disponibles
            document.getElementById('nombre').value = userData.nombre || '';
            document.getElementById('correo').value = userData.correo || '';
            document.getElementById('rut').value = userData.rut || '';
        }

        // Ejecutar al cargar la página
        window.onload = function() {
            autoCompletarDatos();
        };

        $(function() {
        const today = new Date(); // Obtener la fecha actual
        const todayFormatted = today.toISOString().split('T')[0]; // Formatear la fecha actual a YYYY-MM-DD

        // Configuración de la fecha de inicio
        $("#datepicker_uno").datepicker({
            dateFormat: "yy-mm-dd", // Asegurar que el formato sea YYYY-MM-DD
            minDate: todayFormatted, // Establecer la fecha mínima a la fecha actual
            onSelect: function(dateText) {
                const startDate = new Date(dateText);
                startDate.setDate(startDate.getDate() + 1); // Establecer el día siguiente como fecha mínima para la fecha de término
                $("#datepicker_dos").datepicker("option", "minDate", startDate);
                // Actualizar el campo de fecha_envio
                $('#fecha_envio').val(dateText); // Guardar la fecha seleccionada como fecha_envio
            }
        });

        // Configuración de la fecha de término
        $("#datepicker_dos").datepicker({
            dateFormat: "yy-mm-dd", // Asegurar que el formato sea YYYY-MM-DD
            minDate: todayFormatted, // Establecer la fecha mínima a la fecha actual
            onSelect: function(dateText) {
                const endDate = new Date(dateText);
                const startDate = new Date($("#datepicker_uno").val()); // Obtener la fecha de inicio
                if (endDate < startDate) {
                    alert("La fecha de término no puede ser anterior a la fecha de inicio.");
                    $(this).val(''); // Limpiar la fecha de término si es incorrecta
                }
                // Actualizar el campo de fecha_envio
                $('#fecha_envio').val(dateText); // Guardar la fecha seleccionada como fecha_envio
            }
        });

        // Obtener la hora actual para el campo hora_envio
        const currentTime = new Date().toLocaleTimeString('es-CL', { hour: '2-digit', minute: '2-digit' });
        $('#hora_envio').val(currentTime);
    });
    </script>

    <title>Reserva Vehículo</title>
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
    <div class="container mt-5">
        <div class="form-container">
            <form method="POST" enctype="multipart/form-data">
                <div class="text-center mb-4">
                    <?php echo $render; ?>
                </div>

                <div class="text-center mb-4">
                    <?php echo $garantia; ?>
                </div>

                <!-- Campos de información personal -->
                <div id="personal_info">
                    <div class="form-group mb-3">
                        <label for="rut" class="form-label">Rut</label>
                        <input type="text" name="rut" class="form-control" id="rut" placeholder="Rut sin puntos y con dígito verificador" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre Completo" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control" id="correo" placeholder="ejemplo@mail.com" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="telefono" class="form-label">Número Telefónico</label>
                        <input type="number" name="telefono" class="form-control" id="telefono" placeholder="569..." required>
                    </div>

                    <div class="container mt-4">
                        <label for="datepicker">Fecha de inicio:</label>
                        <input type="text" name="fecha_i" id="datepicker_uno">
                    </div>
                    <div class="container mt-4">
                        <label for="datepicker">Fecha de termino:</label>
                        <input type="text" name="fecha_t" id="datepicker_dos">
                    </div>
                </div>

                <!-- Campos ocultos para enviar la fecha y hora -->
                <input type="hidden" name="fecha_envio" id="fecha_envio" class="form-control">
                <input type="hidden" name="hora_envio" id="hora_envio" class="form-control">

                <div class="mt-4">
                    <button type="submit" class="btn btn-custom form-control">Confirmar Arriendo</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>