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
    $modelo_query = "SELECT nombre_modelo, precio_modelo FROM vehiculo WHERE id_vehiculo = '$id'";
    $modelos = mysqli_query($conexion, $modelo_query);
    $row = mysqli_fetch_assoc($modelos);
    $nombre_modelo = $row['nombre_modelo'];
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

    // Convertir las fechas a 'Y-m-d' (YYYY-MM-DD)
    $fechaInicioConvertida = DateTime::createFromFormat('d-m-Y', $fecha_inicio)->format('Y-m-d');
    $fechaTerminoConvertida = DateTime::createFromFormat('d-m-Y', $fecha_termino)->format('Y-m-d');

    date_default_timezone_set('America/Santiago'); // Ajusta la zona horaria según tu ubicación

    $fecha_envio = date('Y-m-d'); // Obtener fecha desde POST
    $hora_envio = date('H:i:s');  // Obtener hora desde POST

    $query = "UPDATE arriendo_vehiculo SET fecha_arriendo ='$fecha_envio', hora_arriendo='$hora_envio', disponible='0' WHERE id_vehiculo =  $id_vehiculo";

    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $num_arriendo_vehiculo = mysqli_insert_id($conexion);
    
        $query = "INSERT INTO registro_arriendo(id_registro_arriendo, nombre_arrendedor, correo_arrendedor, telefono_arrendedor, sucursal_arriendo, rut,
                    metodo_pago, valor, id_vehiculo, arriendo_concretada, fecha_inicio, fecha_termino, garantia) 
        VALUES ('$num_arriendo_vehiculo','$nombre', '$correo','$telefono','$id_sucursal', '$rut', 'credito', '$render','$id_vehiculo', 
        0,'$fechaInicioConvertida','$fechaTerminoConvertida','$garantia')";
        $resultado = mysqli_query($conexion, $query);

        if ($resultado) {
            echo "<script>
                    window.location.href = 'http://localhost/xampp/renzomotors/utils/correo_arriendo.php';
                  </script>";
            exit();
        } else {
            echo "<script>alert('Error en la reserva: " . mysqli_error($conexion) . "');</script>";
        }
    } else {
        success(false, "Error en la reserva" . mysqli_error($conexion));
    }
}

if ($_SESSION['tipo_persona'] === 'administrador') {
    include '../admin/navbaradmin.php';
} else {
    include '../components/navbaruser.php';
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

            // Configuración de la fecha de inicio
            $("#datepicker_uno").datepicker({
                dateFormat: "dd-mm-yy", // Formato de fecha
                minDate: today, // Establece hoy como fecha mínima
                onSelect: function(dateText) {
                    const startDate = new Date(dateText);
                    startDate.setDate(startDate.getDate() + 1); // Establece el día siguiente como fecha mínima para la fecha de término
                    $("#datepicker_dos").datepicker("option", "minDate", startDate);
                }
            });

            // Configuración de la fecha de término
            $("#datepicker_dos").datepicker({
                dateFormat: "dd-mm-yy", // Formato de fecha
                minDate: today, // Establece hoy como fecha mínima
                onSelect: function(dateText) {
                    const endDate = new Date(dateText);
                    const startDate = new Date($("#datepicker_uno").val()); // Obtener la fecha de inicio
                    if (endDate < startDate) {
                        alert("La fecha de término no puede ser anterior a la fecha de inicio.");
                        $(this).val(''); // Limpia la fecha de término si es incorrecta
                    }
                }
            });
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
                <div class="text-center mb-1" style="color: Blue; font-size: 28px; font-weight: bold;">
                    Arriendo de Vehiculo
                </div>
                <div class="text-center mb-1" style="color: Black; font-size: 28px; font-weight: bold;">
                    <?php echo htmlspecialchars($nombre_modelo); ?>
                </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="text-center mb-4">
                    Valor diario del arriendo: $<?php echo number_format($render, 0, ',', '.'); ?>
                </div>

                <div class="text-center mb-4">
                    La garantía del vehículo es de: $<?php echo number_format($garantia, 0, ',', '.'); ?>
                </div>

                <div class="text-center mb-1" style="color: red; font-size: 12px;">
                    *La garantía debe ser paga con tarjeta de crédito en la sucursal
                </div>

                <!-- Campos de información personal -->
                <div id="personal_info">
                    <div class="form-group mb-3">
                        <label for="rut" class="form-label">Rut</label>
                        <input type="text" name="rut" class="form-control" id="rut" placeholder="Rut sin puntos y con dígito verificador"readonly  required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre Completo" readonly required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control" id="correo" placeholder="ejemplo@mail.com" readonly required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="telefono" class="form-label">Número Telefónico</label>
                        <input type="text" name="telefono" class="form-control" id="telefono" placeholder="569..." required
                        minlength="11" maxlength="11"  title="El número debe tener 12 dígitos numéricos.">
                    </div>

                    <div class="form-group mb-3">
                        <label for="datepicker">Fecha de inicio:</label>
                        <input type="text" name="fecha_i" id="datepicker_uno">
                    </div>
                    <div class="form-group mb-3">
                        <label for="datepicker">Fecha de termino:</label>
                        <input type="text" name="fecha_t" id="datepicker_dos">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-custom form-control">Confirmar Arriendo</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>