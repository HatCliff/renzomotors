<?php
session_start();
include('../config/conexion.php'); 

$estado = $_POST['estado'] ?? [];
$orden = $_POST['orden'] ?? '';
$id_marcas = $_POST['id_marcas'] ?? [];
$id_anios = $_POST['id_anios'] ?? [];
$id_combustible = $_POST['id_combustible'] ?? [];
$id_transmision = $_POST['id_transmision'] ?? [];
$nombre_modelo = $_POST['modelo_i'] ?? ''; 

$query = "SELECT v.*, m.nombre_marca, a.anio, p.nombre_pais, t.nombre_transmision
          FROM vehiculo v
          JOIN marca m ON v.id_marca = m.id_marca
          JOIN anio a ON v.id_anio = a.id_anio
          JOIN pais p ON v.id_pais = p.id_pais
          JOIN transmision t ON v.id_transmision = t.id_transmision
          WHERE 1=1 AND v.cantidad_vehiculo != 0
          AND v.arriendo=0";

$resultado = mysqli_query($conexion, $query);
    
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
        $get_estado = $_GET['estado'] ?? [];
        $get_orden = $_GET['orden'] ?? '';
        $get_id_marcas = $_GET['id_marcas'] ?? [];
        $get_id_anios = $_GET['id_anios'] ?? [];
        $get_id_combustible = $_GET['id_combustible'] ?? [];
        $get_id_transmision = $_GET['id_transmision'] ?? [];
        $get_nombre_modelo = $_GET['modelo_i'] ?? '';

        if (!empty($get_estado)) {
            $estado = array_merge($estado, (array) $get_estado );
            $estado = array_unique($estado);
            $estado_string = implode(",", array_map(function($val) {
                return "'" . addslashes($val) . "'";
            }, $estado));
            $query .= " AND v.estado_vehiculo IN ($estado_string)";
        }
        
        if (!empty($get_orden)) {
            if ($get_orden == 'mayor_a_menor') {
                $query .= " ORDER BY precio_modelo DESC";
            } elseif ($get_orden == 'menor_a_mayor') {
                $query .= " ORDER BY precio_modelo ASC";
            } else {
                $query .= " ORDER BY precio_modelo ASC";
            }
        }
        
        if (!empty($get_id_marcas)) {
            $id_marcas = array_merge($id_marcas, (array) $get_id_marcas);
            $id_marcas = array_unique($id_marcas);
            $get_id_marcas_string = implode(",", array_map(function($val) {
                return "'" . addslashes($val) . "'";
            }, $id_marcas));
            $query .= " AND v.id_marca IN ($get_id_marcas_string)";
        }
        
        if (!empty($get_id_anios)) {
            $id_anios = array_merge($id_anios, (array) $get_id_anios);
            $id_anios = array_unique($id_anios);
            $get_id_anios_string = implode(",", array_map(function($val) {
                return "'" . addslashes($val) . "'";
            }, $id_anios));
            $query .= " AND v.id_anio IN ($get_id_anios_string)";
        }
        
        if (!empty($get_id_combustible)) {
            $id_combustible = array_merge($id_combustible, (array) $get_id_combustible);
            $id_combustible = array_unique($id_combustible);
            $get_id_combustible_string = implode(",", array_map(function($val) {
                return "'" . addslashes($val) . "'";
            }, $id_combustible));
            $query .= " AND v.id_tipo_combustible IN ($get_id_combustible_string)";
        }
        
        if (!empty($get_id_transmision)) {
            $id_transmision = array_merge($id_transmision, (array) $get_id_transmision);
            $id_transmision = array_unique($id_transmision);
            $get_id_transmision_string = implode(",", array_map(function($val) {
                return "'" . addslashes($val) . "'";
            }, $id_transmision));
            $query .= " AND v.id_transmision IN ($get_id_transmision_string)";
        }
        
        if (!empty($get_nombre_modelo)) {
            $nombre_modelo = addslashes($get_nombre_modelo);
            $query .= " AND v.nombre_modelo LIKE '%$nombre_modelo%'";
        }

        $resultado = mysqli_query($conexion, $query);
        if (mysqli_num_rows($resultado) == 0) {
            echo "<script>var showAlert = true;</script>";
        } else {
            echo "<script>var showAlert = false;</script>";
        }
    }

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
            $estadosUnicos = array_unique($estado);
            $estado_list = "'" . implode("','", array_map(function($e) use ($conexion) {
                return mysqli_real_escape_string($conexion, $e);
            }, $estadosUnicos)) . "'";
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

        if(!empty($nombre_modelo)){
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Vehiculos</title>
    <style>
        body {
            background-color: #e6e6e6;
        }
        .favorite-icon {
            position: absolute;
            top: 10px;
            right: 22px;
            color: #d3d3d3;
            font-size: 24px;
            cursor: pointer;
            z-index: 999;
        }
        .favorite-checked {
            color: gold;
        }
        .favorite-unchecked {
            color: #d3d3d3;
        }
        .alert-session {
            display: none; 
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050; 
        }
        .card { background: #fffcf4; border-radius: 20px; overflow: hidden; transition: transform 0.3s ease; }
        .card:hover { transform: scale(1.05); }
        .no-style {
            list-style-type: none;
            padding-left: 0;  
        }
        .no-style .accordion-item {
            border-radius: 5px;      
            margin-bottom: 5px;       
            padding: 5px;             
            background-color: #f9f9f9; 
        }
        .accordion-button:not(.collapsed) {
            background-color: #426b42; 
            color: white;
        }
        .accordion-button {
            background-color: #5c636a; 
            color: white; 
            max-width: 100%;
            overflow: hidden; 
            white-space: nowrap; 
            text-overflow: ellipsis; 
            text-align: center; 
            padding: 10px; /
        }
        .no-style .accordion-item label {
            color: #000; 
            font-size: 14px;
        }
        .banner {
            position: relative;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                            url('../src/images/buscador-banner.png'); 
            background-size: cover;
            background-position: center top  ;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<script>
        // Función para convertir los parámetros del formulario a una cadena de consulta (query string)
        function getQueryString() {
        const form = document.getElementById('filtroForm');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);
        return params.toString();  // Devuelve la cadena de parámetros 
    }

    // Llamada a history.replaceState solo si el formulario ha sido enviado
    window.addEventListener('load', function() {
        // Reemplazar la URL con los parámetros del filtro, pero sin recargar la página
        const queryString = getQueryString();
        if (queryString) {
            // Actualizar la URL sin recargar la página
            history.replaceState(null, '', '?' + queryString);
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
    // Detecta cuando se retrocede en el historial (popstate)
    window.addEventListener('popstate', function () {
        // Limpiar los parámetros de la URL
        const baseUrl = 'http://localhost/xampp/renzomotors/pages/buscador_vehiculo.php'; // URL base
        history.replaceState(null, '', baseUrl); // Elimina los parámetros de la URL
    });

    // Al cargar la página, revisar si hay parámetros en la URL
    const params = new URLSearchParams(window.location.search);
    if (params.toString() !== '') {
        // Si hay parámetros en la URL, no hacer nada (esto es cuando se aplican filtros)
        return;
    }

    // Si no hay parámetros en la URL, limpiar la URL y restaurar los filtros con la sesión
    const form = document.getElementById('filtroForm');
    if (form) {
        // Si no hay parámetros en la URL, limpia la URL
        history.replaceState(null, '', window.location.pathname); // Elimina los parámetros al cargar la página
    }
});


</script>
<body class="pt-5 mt-5">
    <!-- Alerta de sesión -->
    <div id="alertSession" class="alert alert-warning alert-session" role="alert">
        Debe iniciar sesión para guardar favoritos.
    </div>
    <div class="container banner">
        <h1 class="text-white">Encuentra el Auto de tus Sueños en RenzoMotors.</h1>
        <h2>Usa nuestro buscador para ver todos nuestros modelos, conoce los precios y características de los mejores vehículos.</h2>
    </div>
    <div class="container mt-5">

        <div class="row mb-4">
            <div class="col-6 ps-0">
                <form id="filtroForm" method="POST" enctype="multipart/form-data">
                    <input class="form-control" type="text" name="modelo_i" placeholder="Ejemplo: chevrolet tracker" aria-label="Modelo del vehículo" value="<?php echo htmlspecialchars($nombre_modelo); ?>"
                    onchange="document.getElementById('filtroForm').submit()">
                    <button type="submit" style="display: none;"></button>
            </div> 
        </div>
        <div class='alert alert-warning alert-container mt-2'id='alerta_datos' role='alert' style='display: none;'>
            ¡No se encontraron resultados!
        </div>
        <div class="row">
                <!-- Botón para abrir Offcanvas en móviles -->
                <button class="btn d-lg-none mb-3 col-4" type="button" data-bs-toggle="offcanvas" 
                    data-bs-target="#offcanvasFiltros" aria-controls="offcanvasFiltros" style="background: #c0c0c0;">
                    Abrir Filtros
                </button>
        </div>

        <div class="row">
            <div class="row w-100 flex-column-reverse flex-lg-row">
                        <!-- Offcanvas para filtros -->
                        <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasFiltros" aria-labelledby="offcanvasFiltrosLabel" style="background-color: #e6e6e6;">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasFiltrosLabel">Filtros</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <!-- Contenido de filtros -->
                                <div class="accordion">
                                    <!-- Filtro: Estado -->
                                    <div class="accordion-item me-1">
                                        <h2 class="accordion-header" id="headingEstado">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseEstado" aria-expanded="false" aria-controls="collapseEstado">
                                                Estado
                                            </button>
                                        </h2>
                                        <div id="collapseEstado" class="accordion-collapse collapse" aria-labelledby="headingEstado"
                                            data-bs-parent="#accordionFiltros">
                                            <div class="accordion-body">
                                            <ul class="no-style">
                                                <li class="accordion-item">
                                                    <label for="estadoNuevo">
                                                        <input type="checkbox" id="estadoNuevo" name="estado[]" value="nuevo"
                                                        <?php if (in_array('nuevo', $estado)) echo 'checked'; ?>
                                                        onchange="handleCheckboxChange(this, 'estado', 'nuevo')"> Nuevo
                                                    </label>
                                                </li>
                                                <li class="accordion-item">
                                                    <label for="estadoUsado">
                                                        <input type="checkbox" id="estadoUsado" name="estado[]" value="usado"
                                                        <?php if (in_array('usado', $estado)) echo 'checked'; ?>
                                                        onchange="handleCheckboxChange(this, 'estado', 'usado')"> Usado
                                                    </label>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Filtro: Ordenar por -->
                                    <div class="accordion-item me-1">
                                        <h2 class="accordion-header" id="headingOrden">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOrden" aria-expanded="false"
                                                    aria-controls="collapseOrden">
                                                Ordenar por
                                            </button>
                                        </h2>
                                        <div id="collapseOrden" class="accordion-collapse collapse" aria-labelledby="headingOrden"
                                            data-bs-parent="#accordionFiltros">
                                            <div class="accordion-body">
                                                <ul class="no-style">
                                                    <li class="accordion-item">
                                                        <label for="ordenMayor">
                                                            <input type="radio" id="ordenMayor" name="orden" value="mayor_a_menor"
                                                                <?php if ($orden == 'mayor_a_menor') echo 'checked'; ?>
                                                                onchange="document.getElementById('filtroForm').submit()"> Precio de mayor a menor
                                                        </label>
                                                    </li>
                                                    <li class="accordion-item">
                                                        <label for="ordenMenor">
                                                            <input type="radio" id="ordenMenor" name="orden" value="menor_a_mayor"
                                                                <?php if ($orden == 'menor_a_mayor') echo 'checked'; ?>
                                                                onchange="document.getElementById('filtroForm').submit()"> Precio de menor a mayor
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Filtro: Marca -->
                                    <div class="accordion-item me-1">
                                        <h2 class="accordion-header" id="headingMarca">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseMarca" aria-expanded="false"
                                                    aria-controls="collapseMarca">
                                                Marca
                                            </button>
                                        </h2>
                                        <div id="collapseMarca" class="accordion-collapse collapse" aria-labelledby="headingMarca"
                                            data-bs-parent="#accordionFiltros">
                                            <div class="accordion-body">
                                            <ul class="no-style">
                                                <?php
                                                $consulta = mysqli_query($conexion, "SELECT * FROM marca");
                                                while ($row = mysqli_fetch_assoc($consulta)) {
                                                    $isChecked = in_array($row['id_marca'], $id_marcas) ? 'checked' : '';
                                                    echo "<li class='accordion-item'>";
                                                    echo "<label>";
                                                    echo "<input type='checkbox' name='id_marcas[]' value='{$row['id_marca']}' $isChecked 
                                                          onchange='handleCheckboxChange(this, \"id_marcas\", \"{$row['id_marca']}\")'>";
                                                    echo "   {$row['nombre_marca']}";
                                                    echo "</label>";
                                                    echo "</li>";
                                                }
                                                ?>
                                            </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Filtro: Año -->
                                    <div class="accordion-item me-1">
                                        <h2 class="accordion-header" id="headingAnio">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseAnio" aria-expanded="false"
                                                    aria-controls="collapseAnio">
                                                Año
                                            </button>
                                        </h2>
                                        <div id="collapseAnio" class="accordion-collapse collapse" aria-labelledby="headingAnio"
                                            data-bs-parent="#accordionFiltros">
                                            <div class="accordion-body">
                                            <ul class="no-style">
                                                <?php
                                                $consulta = mysqli_query($conexion, "SELECT * FROM anio");
                                                while ($row = mysqli_fetch_assoc($consulta)) {
                                                    $isChecked = in_array($row['id_anio'], $id_anios) ? 'checked' : '';
                                                    echo "<li class='accordion-item'>";
                                                    echo "<label>";
                                                    echo "<input type='checkbox' name='id_anios[]' value='{$row['id_anio']}' $isChecked 
                                                        onchange='handleCheckboxChange(this, \"id_anios\", \"{$row['id_anio']}\")'>";
                                                    echo "  {$row['anio']}";
                                                    echo "</label>";
                                                    echo "</li>";
                                                }
                                                ?>
                                            </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Filtro: Combustible -->
                                    <div class="accordion-item me-1">
                                        <h2 class="accordion-header" id="headingCombustible">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseCombustible" aria-expanded="false"
                                                    aria-controls="collapseCombustible">
                                                Combustible
                                            </button>
                                        </h2>
                                        <div id="collapseCombustible" class="accordion-collapse collapse" aria-labelledby="headingCombustible"
                                            data-bs-parent="#accordionFiltros">
                                            <div class="accordion-body">
                                            <ul class="no-style">
                                                <?php
                                                $consulta = mysqli_query($conexion, "SELECT * FROM tipo_combustible");
                                                while ($row = mysqli_fetch_assoc($consulta)) {
                                                    $isChecked = in_array($row['id_tipo_combustible'], $id_combustible) ? 'checked' : '';
                                                    echo "<li class='accordion-item'>";
                                                    echo "<label>";
                                                    echo "<input type='checkbox' name='id_combustible[]' value='{$row['id_tipo_combustible']}' 
                                                        $isChecked onchange='handleCheckboxChange(this, \"id_combustible\", \"{$row['id_tipo_combustible']}\")'>";
                                                    echo "   {$row['nombre_tipo_combustible']}";
                                                    echo "</label>";
                                                    echo "</li>";
                                                }
                                                ?>
                                            </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Filtro: Transmisión -->
                                    <div class="accordion-item me-1">
                                        <h2 class="accordion-header" id="headingTransmision">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTransmision" aria-expanded="false"
                                                    aria-controls="collapseTransmision">
                                                Transmisión
                                            </button>
                                        </h2>
                                        <div id="collapseTransmision" class="accordion-collapse collapse" aria-labelledby="headingTransmision"
                                            data-bs-parent="#accordionFiltros">
                                            <div class="accordion-body">
                                                <ul class="no-style">
                                                    <?php
                                                    $consulta = mysqli_query($conexion, "SELECT * FROM transmision");
                                                    while ($row = mysqli_fetch_assoc($consulta)) {
                                                        $isChecked = in_array($row['id_transmision'], $id_transmision) ? 'checked' : '';
                                                        echo "<li class='accordion-item'>";
                                                        echo "<label>";
                                                        echo "<input type='checkbox' name='id_transmision[]' value='{$row['id_transmision']}' 
                                                            $isChecked onchange='handleCheckboxChange(this, \"id_transmision\", \"{$row['id_transmision']}\")'>";
                                                        echo " {$row['nombre_transmision']}";
                                                        echo "</label>";
                                                        echo "</li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>                                  
                                </div>

                                <!-- Botón para limpiar filtros -->
                                <div class="d-flex gap-2 mt-3 mb-4 justify-content-center">
                                    <button type="submit" name="Limpiar" id="Limpiar" class="btn mt-4" style="background: #c0c0c0;">Limpiar Filtros</button>
                                </div>
                            </div>
                        </div>

                <!-- buscador y filtros -->
                <div class="col-lg-2 col-12  d-none d-lg-block">
                <div class="px-2" style="background: #fffcf4; border-radius: 20px; border: 0.1em solid grey;">
                    <h3 class="mb-4 mt-3 d-flex justify-content-center">Filtros</h3>   
                        <div class="col d-flex flex-column mt-3" >
                                <div class="accordion">
                                    <!-- Filtro: Estado -->
                                    <div class="accordion-item me-1">
                                        <h2 class="accordion-header" id="headingEstado">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseEstado" aria-expanded="false" aria-controls="collapseEstado">
                                                Estado
                                            </button>
                                        </h2>
                                        <div id="collapseEstado" class="accordion-collapse collapse" aria-labelledby="headingEstado"
                                            data-bs-parent="#accordionFiltros">
                                            <div class="accordion-body">
                                            <ul class="no-style">
                                                <li class="accordion-item">
                                                    <label for="estadoNuevo">
                                                        <input type="checkbox" id="estadoNuevo" name="estado[]" value="nuevo"
                                                        <?php if (in_array('nuevo', $estado)) echo 'checked'; ?>
                                                        onchange="handleCheckboxChange(this, 'estado', 'nuevo')"> Nuevo
                                                    </label>
                                                </li>
                                                <li class="accordion-item">
                                                    <label for="estadoUsado">
                                                        <input type="checkbox" id="estadoUsado" name="estado[]" value="usado"
                                                        <?php if (in_array('usado', $estado)) echo 'checked'; ?>
                                                        onchange="handleCheckboxChange(this, 'estado', 'usado')"> Usado
                                                    </label>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Filtro: Ordenar por -->
                                    <div class="accordion-item me-1">
                                        <h2 class="accordion-header" id="headingOrden">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOrden" aria-expanded="false"
                                                    aria-controls="collapseOrden">
                                                Ordenar por
                                            </button>
                                        </h2>
                                        <div id="collapseOrden" class="accordion-collapse collapse" aria-labelledby="headingOrden"
                                            data-bs-parent="#accordionFiltros">
                                            <div class="accordion-body">
                                                <ul class="no-style">
                                                    <li class="accordion-item">
                                                        <label for="ordenMayor">
                                                            <input type="radio" id="ordenMayor" name="orden" value="mayor_a_menor"
                                                                <?php if ($orden == 'mayor_a_menor') echo 'checked'; ?>
                                                                onchange="document.getElementById('filtroForm').submit()"> Precio de mayor a menor
                                                        </label>
                                                    </li>
                                                    <li class="accordion-item">
                                                        <label for="ordenMenor">
                                                            <input type="radio" id="ordenMenor" name="orden" value="menor_a_mayor"
                                                                <?php if ($orden == 'menor_a_mayor') echo 'checked'; ?>
                                                                onchange="document.getElementById('filtroForm').submit()"> Precio de menor a mayor
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Filtro: Marca -->
                                    <div class="accordion-item me-1">
                                        <h2 class="accordion-header" id="headingMarca">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseMarca" aria-expanded="false"
                                                    aria-controls="collapseMarca">
                                                Marca
                                            </button>
                                        </h2>
                                        <div id="collapseMarca" class="accordion-collapse collapse" aria-labelledby="headingMarca"
                                            data-bs-parent="#accordionFiltros">
                                            <div class="accordion-body">
                                            <ul class="no-style">
                                                <?php
                                                $consulta = mysqli_query($conexion, "SELECT * FROM marca");
                                                while ($row = mysqli_fetch_assoc($consulta)) {
                                                    $isChecked = in_array($row['id_marca'], $id_marcas) ? 'checked' : '';
                                                    echo "<li class='accordion-item'>";
                                                    echo "<label>";
                                                    echo "<input type='checkbox' name='id_marcas[]' value='{$row['id_marca']}' $isChecked 
                                                          onchange='handleCheckboxChange(this, \"id_marcas\", \"{$row['id_marca']}\")'>";
                                                    echo "   {$row['nombre_marca']}";
                                                    echo "</label>";
                                                    echo "</li>";
                                                }
                                                ?>
                                            </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Filtro: Año -->
                                    <div class="accordion-item me-1">
                                        <h2 class="accordion-header" id="headingAnio">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseAnio" aria-expanded="false"
                                                    aria-controls="collapseAnio">
                                                Año
                                            </button>
                                        </h2>
                                        <div id="collapseAnio" class="accordion-collapse collapse" aria-labelledby="headingAnio"
                                            data-bs-parent="#accordionFiltros">
                                            <div class="accordion-body">
                                            <ul class="no-style">
                                                <?php
                                                $consulta = mysqli_query($conexion, "SELECT * FROM anio");
                                                while ($row = mysqli_fetch_assoc($consulta)) {
                                                    $isChecked = in_array($row['id_anio'], $id_anios) ? 'checked' : '';
                                                    echo "<li class='accordion-item'>";
                                                    echo "<label>";
                                                    echo "<input type='checkbox' name='id_anios[]' value='{$row['id_anio']}' $isChecked 
                                                        onchange='handleCheckboxChange(this, \"id_anios\", \"{$row['id_anio']}\")'>";
                                                    echo "  {$row['anio']}";
                                                    echo "</label>";
                                                    echo "</li>";
                                                }
                                                ?>
                                            </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Filtro: Combustible -->
                                    <div class="accordion-item me-1">
                                        <h2 class="accordion-header" id="headingCombustible">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseCombustible" aria-expanded="false"
                                                    aria-controls="collapseCombustible">
                                                Combustible
                                            </button>
                                        </h2>
                                        <div id="collapseCombustible" class="accordion-collapse collapse" aria-labelledby="headingCombustible"
                                            data-bs-parent="#accordionFiltros">
                                            <div class="accordion-body">
                                            <ul class="no-style">
                                                <?php
                                                $consulta = mysqli_query($conexion, "SELECT * FROM tipo_combustible");
                                                while ($row = mysqli_fetch_assoc($consulta)) {
                                                    $isChecked = in_array($row['id_tipo_combustible'], $id_combustible) ? 'checked' : '';
                                                    echo "<li class='accordion-item'>";
                                                    echo "<label>";
                                                    echo "<input type='checkbox' name='id_combustible[]' value='{$row['id_tipo_combustible']}' 
                                                        $isChecked onchange='handleCheckboxChange(this, \"id_combustible\", \"{$row['id_tipo_combustible']}\")'>";
                                                    echo "   {$row['nombre_tipo_combustible']}";
                                                    echo "</label>";
                                                    echo "</li>";
                                                }
                                                ?>
                                            </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Filtro: Transmisión -->
                                    <div class="accordion-item me-1">
                                        <h2 class="accordion-header" id="headingTransmision">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTransmision" aria-expanded="false"
                                                    aria-controls="collapseTransmision">
                                                Transmisión
                                            </button>
                                        </h2>
                                        <div id="collapseTransmision" class="accordion-collapse collapse" aria-labelledby="headingTransmision"
                                            data-bs-parent="#accordionFiltros">
                                            <div class="accordion-body">
                                                <ul class="no-style">
                                                    <?php
                                                    $consulta = mysqli_query($conexion, "SELECT * FROM transmision");
                                                    while ($row = mysqli_fetch_assoc($consulta)) {
                                                        $isChecked = in_array($row['id_transmision'], $id_transmision) ? 'checked' : '';
                                                        echo "<li class='accordion-item'>";
                                                        echo "<label>";
                                                        echo "<input type='checkbox' name='id_transmision[]' value='{$row['id_transmision']}' 
                                                            $isChecked onchange='handleCheckboxChange(this, \"id_transmision\", \"{$row['id_transmision']}\")'>";
                                                        echo "  {$row['nombre_transmision']}";
                                                        echo "</label>";
                                                        echo "</li>";
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <!-- Limpiar filtros -->
                        <div class="d-flex gap-2 mt-3 mb-4 d-flex justify-content-center">
                            <button type="submit" name="Limpiar" id="Limpiar" class="btn mt-4" style="background: #c0c0c0;">Limpiar Filtros</button>
                        </div>
                    </form>
                </div>
                </div><!-- termina buscador y filtros -->    

                <!-- vehiculos -->                                      
                <div class="col-lg-10 col-12" id="vehiculos-container">
                    <div class="row">
                        <?php
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                            $id_vehiculo = $fila['id_vehiculo'];
                            $isFavorito = false;
                            if (isset($_SESSION['rut'])) {
                                $id_usuario = $_SESSION['rut'];
                                $favorito_query = "SELECT * FROM vehiculo_favorito WHERE rut = '$id_usuario' AND id_vehiculo = $id_vehiculo";
                                $favorito_result = mysqli_query($conexion, $favorito_query);
                                $isFavorito = mysqli_num_rows($favorito_result) > 0;
                            }
                            echo "<div class='col-12 col-sm-6 col-md-4 mb-4 d-flex align-items-stretch position-relative'>";

                            // Icono de favorito en la esquina superior derecha
                            echo "<div class='favorite-icon' id='icono-favorito-$id_vehiculo'>";
                            echo "<i class='fas fa-star " . ($isFavorito ? 'favorite-checked' : 'favorite-unchecked') . "' onclick='toggleFavorito(event, $id_vehiculo);'></i>";
                            echo "</div>";


                            // Contenido de la tarjeta
                            echo "<a href='vehiculo.php?id={$fila['id_vehiculo']}' class='text-decoration-none w-100'>";
                            echo "<div class='card h-100 d-flex flex-column' style='background: #fffcf4; border-radius: 20px; overflow: hidden;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);'>";

                            // Carrusel de fotos del vehículo
                            $fotos_resultado = mysqli_query($conexion, "SELECT ruta_foto FROM fotos_vehiculo WHERE id_vehiculo = $id_vehiculo");
                            echo "<div id='carousel{$id_vehiculo}' class='carousel slide' data-bs-ride='carousel'>";
                            echo "<div class='carousel-inner'>";
                            $active = "active";
                            while ($foto = mysqli_fetch_assoc($fotos_resultado)) {
                                $ruta_imagen = '../admin/mantenedores/vehiculo/' . $foto['ruta_foto'];
                                echo "<div class='carousel-item $active'>";
                                echo "<div style='background-image: url($ruta_imagen); background-size: cover; background-position: center; height: 180px; border-radius: 15px 15px 0 0;'></div>";
                                echo "</div>";
                                $active = "";
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
                            echo "<div class='position-absolute p-2' style='top: 10px; left: 10px;'>
                                    <span class='badge bg-light text-dark border' style='border-radius: 20px; padding: 5px 10px;'>{$fila['estado_vehiculo']}</span>
                                </div>";

                            // Información del vehículo
                            echo "<div class='card-body mt-1 text-center py-2'>";
                            $precio_formateado = number_format($fila['precio_modelo'], 0, ',', '.');
                            echo "<h4 class='card-title text-dark fw-bold mb-2'>{$fila['nombre_modelo']}</h4>";
                            echo "<p class='fw-bold mb-2' style='color: #3c4043;'>$ {$precio_formateado} CLP - {$fila['anio']}</p>";
                            echo "<p class='text-muted mb-2'>{$fila['nombre_pais']} </p>";
                            echo "</div>";

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

                            echo "</div>"; // Cierre de div.card
                            echo "</a>";   // Cierre de enlace
                            echo "</div>"; // Cierre de columna
                        }
                        ?>
                    </div>
                </div> <!-- termina vehiculo -->
            </div>      
        </div>
    </div> <!-- container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer class="mt-5">
    <?php
        include("../components/footer.php")
    ?>
</footer>
</html>
<script>
        // Función para manejar los cambios en los checkboxes
        function handleCheckboxChange(checkbox, tipo, valor) {
        let form = document.getElementById('filtroForm');
        
        // Si el checkbox está desmarcado, lo eliminamos del array
        if (!checkbox.checked) {
            removeValueFromArray(tipo, valor);
        }

        // Se envía el formulario después del cambio
        form.submit();
    }

    // Función para manejar los cambios en los selects (multiselect)
    function handleSelectChange(select, tipo) {
        let form = document.getElementById('filtroForm');
        
        // Se envía el formulario después de seleccionar o deseleccionar
        form.submit();
    }

    // Función para eliminar el valor del array en caso de que un checkbox sea desmarcado
    function removeValueFromArray(tipo, valor) {
        let inputs = document.querySelectorAll(`input[name="${tipo}[]"]`);
        inputs.forEach(function(input) {
            if (input.value === valor) {
                input.remove();
            }
        });
    }
</script>
<script>
        // Mostrar la alerta si no hay resultados
        if (typeof showAlert !== 'undefined' && showAlert) {
            document.getElementById('alerta_datos').style.display = 'block';
        } else {
            document.getElementById('alerta_datos').style.display = 'none';
        }
</script>
<script>
    function actualizar_fav(id_vehiculo, icono) {
        // Llama a verificar_favorito.php y actualiza el ícono directamente en el elemento pasado
        $.get('favoritos/verificar_favorito.php', { id_vehiculo: id_vehiculo }, function (mensaje, estado) {
            // Verifica si el mensaje contiene "favorite-checked" para decidir el color y clase
            const isFavorito = mensaje.includes('favorite-checked');
            icono.classList.toggle('favorite-checked', isFavorito);
            icono.classList.toggle('favorite-unchecked', !isFavorito);
            icono.style.color = isFavorito ? '#FFD700' : '#CCCCCC';
        });
    }

    function toggleFavorito(event, id_vehiculo) {
        event.stopPropagation();

        <?php if (!isset($_SESSION['rut'])) : ?>
            let alert = document.getElementById('alertSession');
            alert.style.display = 'block';
            setTimeout(function () {
                alert.style.display = 'none';
            }, 3000);
            return;
        <?php endif; ?>

        var icono = event.target;
        var isFavorito = icono.classList.contains('favorite-checked');

        // AJAX para alternar el favorito
        const datos = { id_vehiculo: id_vehiculo, action: isFavorito ? 'remove' : 'add' };
        console.log("Datos enviados:", datos); // Esto imprimirá los datos en la consola del navegador

        $.post('favoritos/toggle_favorito.php', datos, function (response) {
            console.log("Respuesta del servidor:", response); // Imprime la respuesta recibida
            if (response.success) {
                actualizar_fav(id_vehiculo, icono);
            } else {
                alert('Hubo un error al actualizar el favorito: ' + (response.error || ''));
            }
        }, 'json').fail(function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", {
                textStatus: textStatus,
                errorThrown: errorThrown,
                responseText: jqXHR.responseText, // Verifica el contenido del error
            });
            alert("Error en la solicitud AJAX: " + textStatus + " - " + errorThrown);
        });
    }
</script>