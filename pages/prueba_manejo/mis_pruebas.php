<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../../config/conexion.php');

if (isset($_SESSION['usuario'])) {

    if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
        include '../../admin/navbaradmin.php';
    } else {
        include '../../components/navbaruser.php';
    }

    $rut_user = $_SESSION['rut'];
    $solicitudes = "SELECT * FROM agenda_prueba WHERE rut_usuario = '$rut_user'";
    $result_solicitudes = $conexion->query($solicitudes);
} else {
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Detalles del Vehículo</title>
</head>

<body class="pt-5">
    <div class="container mt-5">
        <div class="row">
            <h1 class="mb-3">Mis reservas prueba de manejo</h1>
            <hr class="mb-3">
            <div class="col-lg-12 mb-3">
            <?php
while ($prueba = $result_solicitudes->fetch_assoc()) {
    if (empty($prueba['vehiculo_modelo_prueba'])) {
        echo "<div>Error: vehiculo_modelo_prueba está vacío para este registro.</div>";
        continue;
    }

    // Obtener datos del vehículo
    $vehiculo_query = "SELECT * FROM vehiculo WHERE id_vehiculo = '" . $prueba['vehiculo_modelo_prueba'] . "'";
    $result_vehiculo = $conexion->query($vehiculo_query);
    $vehiculo = $result_vehiculo->fetch_assoc();

    // Obtener la foto del vehículo
    $foto_query = "SELECT ruta_foto FROM fotos_vehiculo WHERE id_vehiculo = '" . $vehiculo['id_vehiculo'] . "' LIMIT 1";
    $result_foto = $conexion->query($foto_query);
    $foto_vehiculo = '';
    if ($result_foto && $result_foto->num_rows > 0) {
        $foto = $result_foto->fetch_assoc();
        $foto_vehiculo = $foto['ruta_foto']; // Asignamos la ruta de la foto
    }

    // Obtener nombre de la sucursal
    $sucursal_query = "SELECT nombre_sucursal FROM sucursal WHERE id_sucursal = '" . $prueba['id_sucursal'] . "'";
    $result_sucursal = $conexion->query($sucursal_query);
    $nombre_sucursal = '';
    if ($result_sucursal && $result_sucursal->num_rows > 0) {
        $sucursal = $result_sucursal->fetch_assoc();
        $nombre_sucursal = $sucursal['nombre_sucursal'];
    } else {
        $nombre_sucursal = 'Sucursal no encontrada';
    }

    // Renderizar los datos
    echo "
    <div class='mb-3 border d-flex flex-row align-items-stretch shadow position-relative' 
         style='border-radius: 20px; overflow: hidden; max-height: 300px;'>
        <div class='d-flex align-items-center'>
            <img src='/../xampp/renzomotors/admin/mantenedores/vehiculo/{$foto_vehiculo}' alt='Imagen del Vehículo' 
                 style='width: 100%; max-width: 400px; height: auto; max-height: 300px; object-fit: cover; border-radius: 20px 0 0 20px;'>
        </div>
        <div class='p-3 d-flex justify-content-between'>
            <div class='me-3'>
                <h5 class='mb-3'><strong>Información General</strong></h5>
                <ul style='list-style: none; padding-left: 20px;'>
                    <li><strong>Nombre Sucursal:</strong> {$nombre_sucursal}</li>
                    <li><strong>RUT Conductor:</strong> {$prueba['rut_conductor']}</li>
                    <li><strong>Nombre Conductor:</strong> {$prueba['nombre_conductor']}</li>
                    <li><strong>Correo Conductor:</strong> {$prueba['correo_conductor']}</li>
                    <li><strong>Teléfono Conductor:</strong> {$prueba['telefono_conductor']}</li>
                    <li><strong>Fecha de Prueba:</strong> {$prueba['fecha_prueba']}</li>
                    <li><strong>Hora de Prueba:</strong> {$prueba['hora_prueba']}</li>
                </ul>
            </div>
            <div>
                <h5 class='mb-3'><strong>Detalles del Vehículo</strong></h5>
                <ul style='list-style: none; padding-left: 20px;'>
                    <li><strong>Modelo:</strong> {$vehiculo['nombre_modelo']}</li>
                    <li><strong>Precio:</strong> $ {$vehiculo['precio_modelo']}</li>
                    <li><strong>Cantidad de Puertas:</strong> {$vehiculo['cantidad_puertas']}</li>
                    <li><strong>Caballos de Fuerza:</strong> {$vehiculo['caballos_fuerza']}</li>
                    <li><strong>Kilometraje:</strong> {$vehiculo['kilometraje']} km</li>
                </ul>
            </div>
            <div class='mx-auto my-auto'>
                <!-- Botón para abrir el modal de reagendar -->
                <ul class='mb-1'>
                    <button class='btn btn-sm btn-secondary' 
                            data-bs-toggle='modal' 
                            data-bs-target='#reagendarModal'
                            data-rut_conductor='{$prueba['rut_conductor']}'
                            data-correo_conductor='{$prueba['correo_conductor']}'
                            data-fecha_prueba='{$prueba['fecha_prueba']}'
                            data-hora_prueba='{$prueba['hora_prueba']}'>Reagendar prueba de manejo.</button>
                </ul>
                <!-- Botón para abrir el modal de cancelar -->
                <ul class='mb-1'>
                    <button class='btn btn-sm btn-danger' 
                            data-bs-toggle='modal' 
                            data-bs-target='#cancelarModal'
                            data-rut_conductor='{$prueba['rut_conductor']}'
                            data-correo_conductor='{$prueba['correo_conductor']}'
                            data-fecha_prueba='{$prueba['fecha_prueba']}'
                            data-hora_prueba='{$prueba['hora_prueba']}'>Cancelar prueba de manejo.</button>
                </ul>
            </div>
        </div>
    </div>";
}
?>


            </div>
        </div>
    </div>
<!-- Modal para Reagendar -->
<div class="modal fade" id="reagendarModal" tabindex="-1" aria-labelledby="reagendarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reagendarModalLabel">Reagendar prueba de manejo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario de reagendar -->
                <form action="reagendar_prueba.php" method="POST">
                    <input type="hidden" id="rut_conductor" name="rut_conductor">
                    <input type="hidden" id="correo_conductor" name="correo_conductor">
                    <input type="hidden" id="fecha_prueba" name="fecha_prueba">
                    <input type="hidden" id="hora_prueba" name="hora_prueba">
                    
                    <div class="form-group mt-4">
                        <label for="fecha">Fecha de la Prueba</label>
                        <input type="date" id="fecha" name="fecha" class="form-control" required>
                    </div>
                    
                    <div class="form-group mt-4">
                        <label for="hora">Hora de la Prueba</label>
                        <select id="hora" name="hora" class="form-control" required>
                            <?php
                            $hora_inicio = strtotime("08:00");
                            $hora_fin = strtotime("14:00");
                            while ($hora_inicio <= $hora_fin) {
                                $hora_formato = date("H:i", $hora_inicio);
                                echo "<option value='{$hora_formato}'>{$hora_formato}</option>";
                                $hora_inicio = strtotime('+30 minutes', $hora_inicio);
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Reagendar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal para Cancelar -->
<div class="modal fade" id="cancelarModal" tabindex="-1" aria-labelledby="cancelarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelarModalLabel">¿Estás seguro de que deseas cancelar la prueba de manejo?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p>Si cancelas la prueba de manejo, la reserva será eliminada.</p>
                <!-- Formulario para cancelar -->
                <form action="cancelar_prueba.php" method="POST">
                    <input type="hidden" name="rut_conductor" id="rut_conductor">
                    <input type="hidden" name="correo_conductor" id="correo_conductor">
                    <input type="hidden" name="fecha_prueba" id="fecha_prueba">
                    <input type="hidden" name="hora_prueba" id="hora_prueba">
                    <button type="submit" class="btn btn-danger mt-3">Cancelar prueba</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('reagendarModal');
    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const rutConductor = button.getAttribute('data-rut_conductor');
        const correoConductor = button.getAttribute('data-correo_conductor');
        const fechaPrueba = button.getAttribute('data-fecha_prueba');
        const horaPrueba = button.getAttribute('data-hora_prueba');
        
        // Asignamos los valores a los campos ocultos del formulario
        const inputRut = modal.querySelector('#rut_conductor');
        const inputCorreo = modal.querySelector('#correo_conductor');
        const inputFecha = modal.querySelector('#fecha_prueba');
        const inputHora = modal.querySelector('#hora_prueba');
        
        inputRut.value = rutConductor;
        inputCorreo.value = correoConductor;
        inputFecha.value = fechaPrueba;
        inputHora.value = horaPrueba;
    });
    var cancelarModal = document.getElementById('cancelarModal')
    cancelarModal.addEventListener('show.bs.modal', function (event) {
        // Obtener los datos del botón que activó el modal
        var button = event.relatedTarget;
        var rutConductor = button.getAttribute('data-rut_conductor');
        var correoConductor = button.getAttribute('data-correo_conductor');
        var fechaPrueba = button.getAttribute('data-fecha_prueba');
        var horaPrueba = button.getAttribute('data-hora_prueba');
        
        // Rellenar los campos del formulario con los valores del botón
        document.getElementById('rut_conductor').value = rutConductor;
        document.getElementById('correo_conductor').value = correoConductor;
        document.getElementById('fecha_prueba').value = fechaPrueba;
        document.getElementById('hora_prueba').value = horaPrueba;
    });
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
