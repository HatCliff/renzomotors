<?php
include './config/conexion.php';


session_start();
if (isset($_SESSION['tipo_persona'])) {
    if ($_SESSION['tipo_persona'] == 'administrador') {
        include './admin/navbaradmin.php';
    } else {
        include './components/navbaruser.php';
    }
}
else{
    include './components/navbaruser.php';
}

// Consulta de sucursales
$query_sucursales = "SELECT id_sucursal, nombre_sucursal FROM sucursal";
$resultado_sucursales = mysqli_query($conexion, $query_sucursales);

$estado = $_POST['estado'] ?? [];
$orden = $_POST['orden'] ?? '';
$id_marcas = $_POST['id_marcas'] ?? [];
$id_anios = $_POST['id_anios'] ?? [];
$id_combustible = $_POST['id_combustible'] ?? [];
$id_transmision = $_POST['id_transmision'] ?? [];
$nombre_modelo = $_POST['modelo_i'] ?? '';

$query = "SELECT v.*, m.nombre_marca, a.anio, p.nombre_pais
          FROM vehiculo v
          JOIN marca m ON v.id_marca = m.id_marca
          JOIN anio a ON v.id_anio = a.id_anio
          JOIN pais p ON v.id_pais = p.id_pais
          WHERE 1=1 AND v.cantidad_vehiculo != 0 AND v.arriendo=0";

$resultado = mysqli_query($conexion, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Limpiar'])) {
        // Resetea los valores de los filtros a sus valores iniciales
        $estado = $orden = $nombre_modelo = '';
        $id_marcas = $id_anios = $id_combustible = $id_transmision = [];
        // Redirige al mismo formulario para limpiar todos los datos enviados por POST
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Procesa los filtros solo si "Limpiar" no fue presionado
        if (!empty($id_marcas)) {
            $marcas_list = implode(',', array_map('intval', $id_marcas));
            $query .= " AND v.id_marca IN ($marcas_list)";
        }
        if (!empty($estado)) {
            $estado_list = "'" . implode("','", array_map(function($e) use ($conexion) {
                return mysqli_real_escape_string($conexion, $e);
            }, $estado)) . "'";
            $query .= " AND v.estado_vehiculo IN ($estado_list)";
        }
        if (!empty($id_anios)) {
            $anios_list = implode(',', array_map('intval', $id_anios));
            $query .= " AND v.id_anio IN ($anios_list)";
        }
        if (!empty($id_combustible)) {
            $combustibles_list = implode(',', array_map('intval', $id_combustible));
            $query .= " AND v.id_tipo_combustible IN ($combustibles_list)";
        }
        if (!empty($id_transmision)) {
            $transmision_list = implode(',', array_map('intval', $id_transmision));
            $query .= " AND v.id_transmision IN ($transmision_list)";
        }
        if (!empty($nombre_modelo)) {
            $nombre_modelos = mysqli_real_escape_string($conexion, $nombre_modelo);
            $query .= " AND v.nombre_modelo LIKE '%$nombre_modelos%'";
        }
        if ($orden == 'mayor_a_menor') {
            $query .= " ORDER BY precio_modelo DESC";
        } elseif ($orden == 'menor_a_mayor') {
            $query .= " ORDER BY precio_modelo ASC";
        }
        
    }

    $resultado = mysqli_query($conexion, $query);
    if (mysqli_num_rows($resultado) == 0) {
        echo "<script>var showAlert = true;</script>";
    } else {
        echo "<script>var showAlert = false;</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RenzoMotors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="logo.png" type="image/png">
    <style>
        /* Ajustes generales para una apariencia limpia */
        .carousel-item img { width: 100%; height: 600px; object-fit: cover; }
        .dropdown-menu { max-height: 200px; overflow-y: auto; }
        .card { background: #fffcf4; border-radius: 20px; overflow: hidden; transition: transform 0.3s ease; }
        .card:hover { transform: scale(1.05); }
        .btn-secondary, .btn-success, .btn-danger { width: 100%; }
        /* Estilos adicionales para hacer la página más adaptable */
        @media (min-width: 768px) {
            .form-control, .btn { max-width: 300px; }
            .dropdown-toggle { white-space: nowrap; }
        }
    </style>
</head>
<body class="pt-5 mt-3">
    <!-- Carrusel de fotos -->
    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Primer slide -->
            <div class="carousel-item active">
                <img src="./src/images/banner1.jpg" class="d-block w-100" alt="Ver Vehículos">
                <div class="carousel-caption d-none d-md-block ">
                    <h4>Conoce tu Proximo vehículo</h4>
                    <a href="pages/buscador_vehiculo.php" class="btn btn-dark">Ver Vehículos</a>
                </div>
            </div>
            <!-- Segundo slide -->
            <div class="carousel-item">
                <img src="./src/images/banner2.jpg" class="d-block w-100" alt="Cotizar Seguro">
                <div class="carousel-caption d-none d-md-block">
                    <h4>Cotiza tu Seguro</h4>
                    <a href="#" class="btn btn-warning">Cotizar Ahora</a>
                </div>
            </div>
            <!-- Tercer slide -->
            <div class="carousel-item">
                <img src="./src/images/banner3.jpg" class="d-block w-100" alt="Compra Accesorios">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Compra Accesorios</h5>
                    <a href="#" class="btn btn-warning">Ver Accesorios</a>
                </div>
            </div>
        </div>
        <!-- Controles del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
<div class="container mt-5 pt-5">
    <!-- Sección Sucursales -->
    <div class="row">
        <div class="col-md-3">
            <h5>Sucursales</h5>
            <div class="list-group">
                <?php
                if ($resultado_sucursales->num_rows > 0) {
                    while($row = $resultado_sucursales->fetch_assoc()) {
                        echo '<label class="list-group-item">';
                        echo '<input class="form-check-input me-1" type="checkbox" value="">';
                        echo $row['nombre_sucursal'];
                        echo '</label>';
                    }
                } else {
                    echo "No se encontraron sucursales.";
                }
                ?>
            </div>
        </div>

        <!-- Sección Novedades de Vehículos -->
        <div class="col-md-9">
        <div class="row mb-4">
            <!-- buscador y filtros -->
            <div class="row mb-4">
                <h1 class="mb-4">Vehículos</h1>
                <form method="POST" enctype="multipart/form-data" >
                    <div class="d-flex flex-column flex-md-row align-items-center">
                        <div class="col-12 col-md-5 me-md-3 mb-3 mb-md-0 ">
                            <input class="form-control" type="text" name="modelo_i" placeholder="Modelo del vehículo" aria-label="Modelo del vehículo">
                        </div>
                            
                        <div class="col-12 col-md-7 d-flex flex-wrap align-items-center">
                            <div class="dropdown me-1 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="estadoDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Estado
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="estadoDropdown">
                                    <li class="dropdown-item">
                                        <label>
                                            <input type="checkbox" name="estado[]" value="nuevo"<?php if (in_array('nuevo', $estado)) echo 'checked'; ?>> Nuevo
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label>
                                            <input type="checkbox" name="estado[]" value="usado"<?php if (in_array('usado', $estado)) echo 'checked'; ?>> Usado
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown me-1 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="ordenDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Ordenar por
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="ordenDropdown">
                                    <li class="dropdown-item">
                                        <label>
                                            <input type="radio" name="orden" value="mayor_a_menor" <?php if ($orden == 'mayor_a_menor') echo 'checked'; ?>> Precio de mayor a menor
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label>
                                            <input type="radio" name="orden" value="menor_a_mayor" <?php if ($orden == 'menor_a_mayor') echo 'checked'; ?>> Precio de menor a mayor
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown me-1 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="marcaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Marca
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="financiamientoDropdown">
                                    <?php
                                        
                                        $consulta = mysqli_query($conexion, "SELECT * FROM marca");
                                        while ($row = mysqli_fetch_assoc($consulta)) {
                                            $isChecked = in_array($row['id_marca'], $id_marcas) ? 'checked' : '';
                                            echo "<li class='dropdown-item'>";
                                            echo "<label>";
                                            echo "<input type='checkbox' name='id_marcas[]' value='{$row['id_marca']}'  $isChecked>";
                                            echo "{$row['nombre_marca']}";
                                            echo "</label>";
                                            echo "</li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                            <div class="dropdown me-1 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="anioDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Año
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="financiamientoDropdown">
                                    <?php
                                        $consulta = mysqli_query($conexion, "SELECT * FROM anio");
                                        while ($row = mysqli_fetch_assoc($consulta)) {
                                            $isChecked = in_array($row['id_anio'], $id_anios) ? 'checked' : '';
                                            echo "<li class='dropdown-item'>";
                                            echo "<label>";
                                            echo "<input type='checkbox' name='id_anios[]' value='{$row['id_anio']}' $isChecked>";
                                            echo "{$row['anio']}";
                                            echo "</label>";
                                            echo "</li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                            <div class="dropdown me-1 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="combusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Combustible
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="combusDropdown">
                                    <?php
                                        $consulta = mysqli_query($conexion, "SELECT * FROM tipo_combustible");
                                        while ($row = mysqli_fetch_assoc($consulta)) {
                                            $isChecked = in_array($row['id_tipo_combustible'], $id_combustible) ? 'checked' : '';
                                            echo "<li class='dropdown-item'>";
                                            echo "<label>";
                                            echo "<input type='checkbox' name='id_combustible[]' value='{$row['id_tipo_combustible']}' $isChecked>";
                                            echo "{$row['nombre_tipo_combustible']}";
                                            echo "</label>";
                                            echo "</li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                            <div class="dropdown me-1 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="transmisionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Transmisión
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="transmisionDropdown">
                                    <?php
                                        $consulta = mysqli_query($conexion, "SELECT * FROM transmision");
                                        while ($row = mysqli_fetch_assoc($consulta)) {
                                            $isChecked = in_array($row['id_transmision'], $id_transmision) ? 'checked' : '';
                                            echo "<li class='dropdown-item'>";
                                            echo "<label>";
                                            echo "<input type='checkbox' name='id_transmision[]' value='{$row['id_transmision']}' $isChecked>";
                                            echo "{$row['nombre_transmision']}";
                                            echo "</label>";
                                            echo "</li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-2">
                        <button type="submit" class="btn btn-success mt-4" >Aplicar Filtros</button>
                        <button type="submit" name="Limpiar" id="Limpiar" class="btn btn-danger mt-4"  >Limpiar Filtros</button>
                    </div>                
                </form>
                <div class='alert alert-danger alert-container' id='alerta_datos' role='alert' style='display: none;'>¡No se encontraron resultados!</div>
            </div>
        
            <!-- Muestra todos los vehiculos -->
            <div class="row">
            <?php
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<div class='col-12 col-sm-6 col-md-4 mb-4 d-flex align-items-stretch'>";
                    echo "<a href='pages/vehiculo.php?id={$fila['id_vehiculo']}' class='text-decoration-none w-100'>";
                    echo "<div class='card h-100 d-flex flex-column' style='background: #fffcf4; border-radius: 20px; overflow: hidden;'>";
                    // Carrusel de fotos del vehículo
                    $id_vehiculo = $fila['id_vehiculo'];
                    $fotos_resultado = mysqli_query($conexion, "SELECT ruta_foto FROM fotos_vehiculo WHERE id_vehiculo = $id_vehiculo");
                    
                    echo "<div id='carousel{$id_vehiculo}' class='carousel slide' data-bs-ride='carousel'>";
                    echo "<div class='carousel-inner'>";
                    $active = "active";
                    while ($foto = mysqli_fetch_assoc($fotos_resultado)) {
                        $ruta_imagen = 'admin/mantenedores/vehiculo/' . $foto['ruta_foto'];
                        echo "<div class='carousel-item $active'>";
                        echo "<div style='background-image: url($ruta_imagen); background-size: cover; background-position: center; height: 180px; border-radius: 15px 15px 0 0;'></div>";
                        echo "</div>";
                        $active = ""; // Solo la primera imagen es "active"
                    }
                    echo "</div>";
                    echo "<button class='carousel-control-prev' type='button' data-bs-target='#carousel{$id_vehiculo}' data-bs-slide='prev'>
                            <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                            <span class='visually-hidden'>Previous</span>
                        </button>";
                    echo "<button class='carousel-control-next' type='button' data-bs-target='#carousel{$id_vehiculo}' data-bs-slide='next'>
                            <span class='carousel-control-next-icon' aria-hidden='true'></span>
                            <span class='visually-hidden'>Next</span>
                        </button>";
                    echo "</div>";

                    // Estado del vehículo (Nuevo o Usado)
                    echo "
                        <div class='position-absolute p-2' style='top: 10px; left: 10px;'>
                            <span class='badge bg-light text-dark border' style='border-radius: 20px; padding: 5px 10px;'>{$fila['estado_vehiculo']}</span>
                        </div>
                    ";

                    // Información del vehículo
                    echo "<div class='card-body mt-1 text-center py-2'>";
                    $precio_formateado = number_format($fila['precio_modelo'], 0, ',', '.');
                    echo "<h5 class='card-title text-dark fw-bold mb-2'>{$fila['nombre_modelo']}</h5>";
                    echo "<p class='text-success fw-bold mb-2'>$ {$precio_formateado} CLP - {$fila['anio']}</p>";
                    echo "<p class='text-muted mb-2'>{$fila['nombre_pais']}</p>";
                    echo "</div>"; // card-body

                    // Colores del vehículo en la parte inferior
                    $colores_resultado = mysqli_query($conexion, "SELECT c.codigo_color 
                                                                FROM color_vehiculo vc
                                                                JOIN color c ON vc.id_color = c.id_color
                                                                WHERE vc.id_vehiculo = $id_vehiculo");
                    echo "<div class='d-flex justify-content-center align-items-center mb-2'>";
                    while ($color = mysqli_fetch_assoc($colores_resultado)) {
                        $codigo_color = htmlspecialchars($color['codigo_color']);
                        echo "<span style='background-color: $codigo_color; width: 20px; height: 20px; border-radius: 50%; display: inline-block; margin: 0 5px;'></span>";
                    }
                    echo "</div>";

                    echo "</div>"; // card
                    echo "</a>";
                    echo "</div>";
                }
                ?>
                    </div>    
                </div>
            </div>
    
            </div>
        </div>
    </div>
    <div class="container-fluid">        
        <div class="row align-items-center my-8">
            <div class="col text-end">
                <img class="rounded float-end" height="auto" width="700px" src="./src/images/mechanic.jpg" alt="Servicio técnico">
            </div>
            <div class="col text-center">
                <h1>¿Problemas con tu auto?</h1>
                <button class="btn mt-3" style="background: linear-gradient(90deg, #0B8347 0%, #008040 52%, #000000 100%); color: #fff;">
                    Haz tu mantenimiento con nosotros
                </button>
            </div>
        </div>
    </div>
    <?php
            include './components/footer.php';
    ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
