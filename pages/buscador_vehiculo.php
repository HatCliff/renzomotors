<?php
session_start();

// Incluye el navbar correspondiente según el tipo de usuario
if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
    // Usuario es administrador, incluye el navbar de administrador
    include '../admin/navbaradmin.php';
} else {
    // Usuario es normal, incluye el navbar de usuario
    include '../components/navbaruser.php';
}
include('../config/conexion.php'); 

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
          WHERE 1=1 AND v.cantidad_vehiculo != 0";

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

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Vehiculos</title>
    <!-- Dar color al fondo de la pagina -->
    <style>
        body{
            background: #E6E6E6;
        }
        
    </style>
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
</script>
<body class="pt-5">
    <div class="container mt-5">
    <div class="col-md-12">
        <div class="row mb-4">
            <!-- buscador y filtros -->
            <div class="row mb-4">
                <h1 class="mb-4">Vehículos</h1>
                <form id="filtroForm" method="POST" enctype="multipart/form-data" >
                    <div class="d-flex flex-column flex-md-row align-items-center">
                        <div class="col-12 col-md-5 me-md-3 mb-3 mb-md-0 ">
                            <input class="form-control" type="text" name="modelo_i" placeholder="Modelo del vehículo" 
                            aria-label="Modelo del vehículo" value="<?php echo htmlspecialchars($nombre_modelo); ?>"  
                            onchange="document.getElementById('filtroForm').submit()">
                            <button type="submit" style="display: none;"></button>
                        </div>
                            
                        <div class="col-12 col-md-7 d-flex flex-wrap align-items-center">
                            <div class="dropdown me-1 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" 
                                id="estadoDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Estado
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="estadoDropdown">
                                    <li class="dropdown-item">
                                        <label>
                                            <input type="checkbox" name="estado[]" value="nuevo"
                                            <?php if (in_array('nuevo', $estado)) echo 'checked'; ?> 
                                            onchange="document.getElementById('filtroForm').submit()"> Nuevo
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label>
                                            <input type="checkbox" name="estado[]" value="usado"
                                            <?php if (in_array('usado', $estado)) echo 'checked'; ?> 
                                            onchange="document.getElementById('filtroForm').submit()"> Usado
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown me-1 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" 
                                id="ordenDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Ordenar por
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="ordenDropdown">
                                    <li class="dropdown-item">
                                        <label>
                                            <input type="radio" name="orden" value="mayor_a_menor"
                                             <?php if ($orden == 'mayor_a_menor') echo 'checked'; ?> 
                                             onchange="document.getElementById('filtroForm').submit()"> Precio de mayor a menor
                                        </label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label>
                                            <input type="radio" name="orden" value="menor_a_mayor" 
                                            <?php if ($orden == 'menor_a_mayor') echo 'checked'; ?> 
                                            onchange="document.getElementById('filtroForm').submit()"> Precio de menor a mayor
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown me-1 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" 
                                id="marcaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Marca
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="financiamientoDropdown">
                                    <?php
                                        
                                        $consulta = mysqli_query($conexion, "SELECT * FROM marca");
                                        while ($row = mysqli_fetch_assoc($consulta)) {
                                            $isChecked = in_array($row['id_marca'], $id_marcas) ? 'checked' : '';
                                            echo "<li class='dropdown-item'>";
                                            echo "<label>";
                                            echo "<input type='checkbox' name='id_marcas[]' value='{$row['id_marca']}'  
                                                $isChecked onchange='document.getElementById(\"filtroForm\").submit()'>";
                                            echo "{$row['nombre_marca']}";
                                            echo "</label>";
                                            echo "</li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                            <div class="dropdown me-1 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" 
                                id="anioDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Año
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="financiamientoDropdown">
                                    <?php
                                        $consulta = mysqli_query($conexion, "SELECT * FROM anio");
                                        while ($row = mysqli_fetch_assoc($consulta)) {
                                            $isChecked = in_array($row['id_anio'], $id_anios) ? 'checked' : '';
                                            echo "<li class='dropdown-item'>";
                                            echo "<label>";
                                            echo "<input type='checkbox' name='id_anios[]' value='{$row['id_anio']}' 
                                                $isChecked onchange='document.getElementById(\"filtroForm\").submit()'>";
                                            echo "{$row['anio']}";
                                            echo "</label>";
                                            echo "</li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                            <div class="dropdown me-1 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" 
                                id="combusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Combustible
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="combusDropdown">
                                    <?php
                                        $consulta = mysqli_query($conexion, "SELECT * FROM tipo_combustible");
                                        while ($row = mysqli_fetch_assoc($consulta)) {
                                            $isChecked = in_array($row['id_tipo_combustible'], $id_combustible) ? 'checked' : '';
                                            echo "<li class='dropdown-item'>";
                                            echo "<label>";
                                            echo "<input type='checkbox' name='id_combustible[]' 
                                                value='{$row['id_tipo_combustible']}' $isChecked 
                                                onchange='document.getElementById(\"filtroForm\").submit()'>";
                                            echo "{$row['nombre_tipo_combustible']}";
                                            echo "</label>";
                                            echo "</li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                            <div class="dropdown me-1 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" 
                                id="transmisionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Transmisión
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="transmisionDropdown">
                                    <?php
                                        $consulta = mysqli_query($conexion, "SELECT * FROM transmision");
                                        while ($row = mysqli_fetch_assoc($consulta)) {
                                            $isChecked = in_array($row['id_transmision'], $id_transmision) ? 'checked' : '';
                                            echo "<li class='dropdown-item'>";
                                            echo "<label>";
                                            echo "<input type='checkbox' name='id_transmision[]' 
                                                value='{$row['id_transmision']}' $isChecked 
                                                onchange='document.getElementById(\"filtroForm\").submit()'>";
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
                        <button type="submit" name="Limpiar" id="Limpiar" 
                        class="btn btn-success mt-4" style="background-color: #426B1F;" >Limpiar Filtros</button>
                    </div>                
                </form>
                <div class='alert alert-danger alert-container' 
                id='alerta_datos' role='alert' style='display: none;'>¡No se encontraron resultados!</div>
            </div>
        
            <!-- Muestra todos los vehiculos -->
            <div class="row">
            <?php
while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "<div class='col-12 col-sm-6 col-md-4 mb-4 d-flex align-items-stretch'>";
    echo "<a href='vehiculo.php?id={$fila['id_vehiculo']}' class='text-decoration-none w-100'>";
    echo "<div class='card h-100 d-flex flex-column' style='background: #fffcf4; border-radius: 20px; overflow: hidden;'>";

    // Carrusel de fotos del vehículo
    $id_vehiculo = $fila['id_vehiculo'];
    $fotos_resultado = mysqli_query($conexion, "SELECT ruta_foto FROM fotos_vehiculo WHERE id_vehiculo = $id_vehiculo");
    
    echo "<div id='carousel{$id_vehiculo}' class='carousel slide' data-bs-ride='carousel'>";
    echo "<div class='carousel-inner'>";
    $active = "active";
    while ($foto = mysqli_fetch_assoc($fotos_resultado)) {
        $ruta_imagen = '../admin/mantenedores/vehiculo/' . $foto['ruta_foto'];
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script>
        // Mostrar la alerta si no hay resultados
        if (typeof showAlert !== 'undefined' && showAlert) {
            document.getElementById('alerta_datos').style.display = 'block';
        } else {
            document.getElementById('alerta_datos').style.display = 'none';
        }
</script>