<?php
session_start();
include('../config/conexion.php');

// Verificación de usuario
if (!isset($_SESSION['tipo_persona']) || !in_array($_SESSION['tipo_persona'], ['administrador', 'usuario'])) {
    header("Location: ../pages/login.php");
    exit();
}

// Obtenemos los datos del vehículo
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $precio = 0;

    $modelo_query = "SELECT nombre_modelo, precio_modelo FROM vehiculo WHERE id_vehiculo = '$id'";
    $modelos = mysqli_query($conexion, $modelo_query);
    $render = '';
    while ($modelo = mysqli_fetch_assoc($modelos)) {
        $precio = $modelo['precio_modelo'] * 0.01;
        $render = "
            <h4 class='fw-bold text-primary text-center'>
                " . $modelo['nombre_modelo'] . "
            </h4>
            <p class='fs-6 fw-light fst-italic text-muted text-center'>*Cuota de reserva: $" . number_format($precio, 0, ',', '.') . "</p>
            <input type='hidden' name='precio' value='" . $precio . "'>
        ";
    }

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
    include '../admin/navbaradmin.php';
} else {
    include '../components/navbaruser.php';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <form action='./../auth/transaction.php' method="POST" enctype="multipart/form-data">
                <div class="text-center mb-4">
                    <?php echo $render; ?>
                </div>

                <input type="hidden" name="id_vehiculo" value="<?php echo $id; ?>">

                <!-- Selector para elegir si es para el usuario actual o para un tercero -->
                <div class="form-group mb-3">
                    <label class="form-label">¿La reserva es para usted o para un tercero?</label>
                    <select class="form-select" id="reservation_for" required onchange="togglePersonalInfo()">
                        <option value="self">Para mí</option>
                        <option value="third_party">Para un tercero</option>
                    </select>
                </div>

                <!-- Campos de información personal -->
                <div id="personal_info">
                    <div class="form-group mb-3">
                        <label for="rut" class="form-label">Rut</label>
                        <input type="text" name="rut" class="form-control" id="rut"
                               placeholder="Rut sin puntos y con dígito verificador" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre Completo"
                               required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control" id="correo"
                               placeholder="ejemplo@mail.com" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="telefono" class="form-label">Número Telefónico</label>
                        <input type="number" name="telefono" class="form-control" id="telefono" placeholder="569..."
                               required>
                    </div>
                </div>

                <!-- Selección de color -->
                <div class="mb-3">
                    <label class="form-label">Personaliza tu vehículo:</label>
                    <div class="d-flex justify-content-center">
                        <?php echo $render_color; ?>
                    </div>
                </div>

                <!-- Selección de sucursal -->
                <div class="mb-3">
                    <label for="id_sucursal" class="form-label">Seleccione una sucursal</label>
                    <select class="form-select" name="id_sucursal" required>
                        <?php
                        $disponible = mysqli_query($conexion, "SELECT vs.*, su.nombre_sucursal FROM vehiculo_sucursal vs JOIN sucursal su ON su.id_sucursal = vs.id_sucursal WHERE vs.id_vehiculo = '$id'");
                        while ($disp = mysqli_fetch_assoc($disponible)) {
                            echo '<option value="' . $disp['id_sucursal'] . '">' . $disp['nombre_sucursal'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- Botón de envío -->
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-custom">Pagar Reserva</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Datos del usuario para autocompletar
        const userData = {
            nombre: "<?php echo $_SESSION['nombre'] ?? ''; ?>",
            correo: "<?php echo $_SESSION['correo'] ?? ''; ?>",
            rut: "<?php echo $_SESSION['rut'] ?? ''; ?>"
        };

        function togglePersonalInfo() {
            const reservationFor = document.getElementById('reservation_for').value;
            const personalInfoDiv = document.getElementById('personal_info');

            if (reservationFor === 'self') {
                // Autocompletar datos del usuario
                document.getElementById('nombre').value = userData.nombre;
                document.getElementById('correo').value = userData.correo;
                document.getElementById('rut').value = userData.rut;
            } else {
                // Limpiar los campos para un tercero
                document.getElementById('nombre').value = '';
                document.getElementById('correo').value = '';
                document.getElementById('rut').value = '';
            }
        }

        // Ejecutar al cargar la página para el valor predeterminado (para mí)
        togglePersonalInfo();
    </script>
</body>

</html>
