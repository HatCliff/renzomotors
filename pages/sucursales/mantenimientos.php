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

if(isset($_GET['suc'])){
    $busqueda = $_GET['suc'];
    $mantenimientos = "SELECT s.* FROM servicio s
    JOIN sucursal_servicio ss ON s.id_servicio = ss.id_servicio WHERE ss.id_sucursal = $busqueda";
}
else{
    $mantenimientos = "SELECT * FROM servicio";
}
$resulta_mantenimiento = $conexion->query($mantenimientos)

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

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sucursales</title>
</head>

<style>
    body {
        background: #E6E6E6;
    }
    .banner {
            position: relative;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                            url('../../src/images/banner-mantenciones.jpg'); 
            background-size: cover;
            background-position: center;
            height: 25vh; 
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            z-index: 1;
            text-align: center;
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        }
        .banner h1 {
            font-size: 2rem; 
            margin: 0;
        }

        .banner h2 {
            font-size: 1rem; 
            font-weight: 300;
            margin: 0;
        }
</style>

<body class="pt-5">

    <div class="container mt-5">
    <div class="container banner">
        <h1 class="text-white">Realiza tus Mantenciones con RenzoMotors</h1>
        <h2>Encuentra las mantenciones ideales para tu vehículo, siempre cerca de ti.</h2>
    </div>
        <div class="row">
            <div class="col-12">
                <div class="mt-4">

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
                        $selected = ($row['id_sucursal'] == $busqueda) ? "selected" : "";
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
        </div>
        <div class="row">
            <div class="col-12">
                <div class="">
                    <?php
                    while ($servicio = mysqli_fetch_assoc($resulta_mantenimiento)) {
                        $precio_formateado = number_format($servicio['precio_servicio'], 0, ',', '.');
                        echo "
                        <div class='col-12 mt-3 rounded shadow' style='background: #fffcf4;'>
                            <div class='p-3'>
                                <!-- Título y precio -->
                                <div class='d-flex flex-column flex-md-row justify-content-between align-items-start mb-3'>
                                    <strong class='fs-5'>{$servicio['nombre_servicio']}</strong>
                                    <p class='fw-bold' style='color:#3c4043;'>Desde $ {$precio_formateado}</p>
                                </div>
                        
                                <!-- Imagen y descripción -->
                                <div class='d-flex flex-column flex-md-row align-items-start mb-3'>
                                    <img src='../../admin/mantenedores/servicios/{$servicio['imagen_servicio']}' alt='' class='img-thumbnail img-fluid me-3 mb-3 mb-md-0' style='max-width: 250px;'>
                                    <p class='flex-grow-1'>
                                        <strong>Detalle: </strong>
                                        {$servicio['descripcion_servicio']}
                                    </p>
                                </div>
                        
                                <!-- Contacto y disponibilidad -->
                                <div class='d-flex flex-column flex-md-row justify-content-between align-items-start'>
                                    <p class='text-secondary'>Contacto: +56 {$servicio['telefono_encargado']}</p>
                                    <div class='dropdown mt-2 mt-md-0'>
                                        <button class='btn btn-secondary dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                            Disponible en:
                                        </button>
                                        <ul class='dropdown-menu'>";
                                        $disponibilidad = "SELECT ss.*, s.nombre_sucursal FROM sucursal_servicio ss
                                                           JOIN sucursal s ON ss.id_sucursal = s.id_sucursal
                                                           WHERE id_servicio = {$servicio['id_servicio']}
                                                           ORDER BY zona_sucursal";
                                        $resultado_disponibilidad = $conexion->query($disponibilidad);
                                        while($disponible = mysqli_fetch_assoc($resultado_disponibilidad)){
                                            echo "<li><a class='dropdown-item' href='sucursales.php?suc={$disponible['id_sucursal']}'>{$disponible['nombre_sucursal']}</a></li>";
                                        }
                                        echo "</ul>
                                    </div>
                                </div>
                            </div>
                        </div>";
                                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.js-example-basic-single').select2({
                placeholder: "Selecciona una sucursal",
                allowClear: true,
                width: '100%'
            });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>