<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../../config/conexion.php');

// Incluye el navbar según el tipo de usuario
if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
    include '../../admin/navbaradmin.php';
} else {
    include '../../components/navbaruser.php';
}

$sucursal_mapa = isset($_GET['suc']) ? intval($_GET['suc']) : 1;

$query = "SELECT nombre_sucursal, direccion_sucursal FROM sucursal WHERE id_sucursal = $sucursal_mapa";
$result = mysqli_query($conexion, $query);
$sucursal = mysqli_fetch_assoc($result);

if ($sucursal && isset($sucursal['direccion_sucursal'])) {
    $direccion = $sucursal['direccion_sucursal'];
    $coordenadas = explode(',', $direccion);

    if (count($coordenadas) === 2) {
        $latitud = trim($coordenadas[0]);
        $longitud = trim($coordenadas[1]);
        $nombre_sucursal = $sucursal['nombre_sucursal'];
    } else {
        // Coordenadas por defecto
        $latitud = -33.3042316;
        $longitud = -70.708928;
        $nombre_sucursal = "Formato de coordenadas inválido";
    }
} else {
    // Coordenadas por defecto si no se encuentra la sucursal
    $latitud = -33.3042316;
    $longitud = -70.708928;
    $nombre_sucursal = "Sucursal desconocida";
}

?>

<!doctype html>
<html lang="es">

<head>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sucursales</title>
</head>

<style>
    body {
        background: #E6E6E6;
    }
</style>

<body class="pt-5">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Nuestras Sucursales</h1>

                <div class="mb-3 d-flex">
                    <?php
                    $sucursales = "SELECT * FROM sucursal ORDER BY zona_sucursal";
                    $result_suc = mysqli_query($conexion, $sucursales);
                    $current_zone = '';
                    echo "<select class='form-select js-example-basic-single' name='sucursal_compra' onchange='window.location.href=this.value'>";
                    while ($row = mysqli_fetch_assoc($result_suc)) {
                        if ($current_zone !== $row['zona_sucursal']) {
                            if ($current_zone !== '') {
                                echo "</optgroup>";
                            }
                            $current_zone = $row['zona_sucursal'];
                            echo "<optgroup label='{$current_zone}'>";
                        }
                        $selected = ($row['id_sucursal'] == $sucursal_mapa) ? "selected" : "";
                        echo "<option value='?suc={$row['id_sucursal']}' $selected>{$row['nombre_sucursal']}</option>";
                    }
                    if ($current_zone !== '') {
                        echo "</optgroup>";
                    }
                    echo "</select>";
                    ?>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-center">
            <div id="map" style="height: 450px; width: 100%;"></div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Inicializa Select2
            $('.js-example-basic-single').select2({
                placeholder: "Selecciona una sucursal",
                allowClear: true,
                width: '100%'
            });

            // Configuración inicial del mapa
            const latitude = <?php echo $latitud; ?>;
            const longitude = <?php echo $longitud; ?>;
            const map = L.map('map').setView([latitude, longitude], 15);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            let marker = L.marker([latitude, longitude]).addTo(map)
                .bindPopup("Sucursal <?php echo $nombre_sucursal; ?>")
                .openPopup();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
