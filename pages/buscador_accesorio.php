<?php
session_start();
include('../config/conexion.php'); 

$orden = $_POST['orden'] ?? '';
$id_tipo_accesorio = $_POST['id_tipo_accesorio'] ?? [];
$nombre_accesorio = $_POST['modelo_i'] ?? ''; 

$query = "SELECT DISTINCT a.*, nombre_tipo_accesorio
          FROM accesorio a
          JOIN pertenece_tipo pt ON a.sku_accesorio = pt.sku_accesorio
          JOIN tipo_accesorio ta ON ta.id_tipo_accesorio = pt.id_tipo_accesorio
          WHERE a.stock_accesorio != 0";

$resultado = mysqli_query($conexion, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Limpiar'])) {
        // Resetea los valores de los filtros a sus valores iniciales
        $orden = $nombre_accesorio = '';
        $id_tipo_accesorio = [];
        // Redirige al mismo formulario para limpiar todos los datos enviados por POST
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Procesa los filtros solo si "Limpiar" no fue presionado
        if (!empty($id_tipo_accesorio)) {
            $accesorio_list = implode(',', array_map('intval', $id_tipo_accesorio));
            $query .= " AND pt.id_tipo_accesorio IN ($accesorio_list)";
        }
        
        if(!empty($nombre_accesorio)){
            $nombre_accesorio = mysqli_real_escape_string($conexion, $nombre_accesorio);
            $query .= " AND a.nombre_accesorio LIKE '%$nombre_accesorio%'";
        }

        if ($orden == 'mayor_a_menor') {
            $query .= " ORDER BY precio_accesorio DESC";
        } elseif ($orden == 'menor_a_mayor') {
            $query .= " ORDER BY precio_accesorio ASC";
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
    <title>Accesorios</title>
    <!-- Dar color al fondo de la pagina -->
    <style>
        body{
            background: #E6E6E6;
        }
        .carrito {
            width: 35px;
            height: 100%;
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

    //Función para acceder al modal con ajax:
    
</script>
<body class="pt-5">
    <div class="container mt-5">
    <div class="col-md-12">
        <div class="row mb-4">
            <!-- buscador y filtros -->
            <div class="row mb-4">
                <h1 class="mb-4">Accesorios</h1>
                <form id="filtroForm" method="POST" enctype="multipart/form-data" >
                    <div class="d-flex flex-column flex-md-row align-items-start">
                        <div class="col-12 col-md-5 me-md-3 mb-3 mb-md-0 ">
                            <input class="form-control" type="text" name="accesorio_i" placeholder="Nombre del accesorio" 
                            aria-label="Nombre del accesorio" value="<?php echo htmlspecialchars($nombre_accesorio); ?>"  
                            onchange="document.getElementById('filtroForm').submit()">
                            <button type="submit" style="display: none;"></button>
                        </div>
                            
                        <div class="col-12 col-md-7 d-flex flex-wrap align-items-start justify-content-end">
                            <div class="dropdown me-1 mb-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" 
                                id="categoriaDopdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Categoría
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="categoriaDopdown">
                                    <?php
                                        $consulta = mysqli_query($conexion, "SELECT * FROM tipo_accesorio");
                                        while ($row = mysqli_fetch_assoc($consulta)) {
                                            $isChecked = in_array($row['id_tipo_accesorio'], $id_tipo_accesorio) ? 'checked' : '';
                                            echo "<li class='dropdown-item'>";
                                            echo "<label>";
                                            echo "<input type='checkbox' name='id_tipo_accesorio[]' 
                                                value='{$row['id_tipo_accesorio']}' $isChecked 
                                                onchange='document.getElementById(\"filtroForm\").submit()'>";
                                            echo "{$row['nombre_tipo_accesorio']}";
                                            echo "</label>";
                                            echo "</li>";
                                        }
                                    ?>
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
                            
                            <!-- Carrito -->
                            <div class="mx-2 d-flex justify-content-center align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="carrito" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                </svg>
                            </div>
                            
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" name="Limpiar" id="Limpiar" 
                        class="btn btn-danger mt-4" >Limpiar Filtros</button>
                    </div>                
                </form>
                <div class='alert alert-danger alert-container' 
                id='alerta_datos' role='alert' style='display: none;'>¡No se encontraron resultados!</div>
            </div>
        
            <!-- Muestra todos los vehiculos -->
            <div class="row">
            <?php
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<div class='col-12 col-sm-6 col-md-4 mb-4 d-flex align-items-stretch' style='width: 25%'>";
                    echo "<a href='javascript:void(0);' class='text-decoration-none' id='openModal' data-id='{$fila['sku_accesorio']}'>";
                    echo "<div class='card h-100 d-flex flex-column' style='background: #fffcf4; border-radius: 20px; overflow: hidden;'>";
        
                    // Carrusel de fotos del vehículo
                    $sku_accesorio = $fila['sku_accesorio'];
                    $fotos_resultado = mysqli_query($conexion, "SELECT foto_accesorio FROM fotos_accesorio WHERE sku_accesorio = '$sku_accesorio'");

                    echo "<div id='carousel{$sku_accesorio}' class='carousel slide' data-bs-ride='carousel'>";
                    echo "<div class='carousel-inner'>";
                    $active = "active";
                    while ($foto = mysqli_fetch_assoc($fotos_resultado)) {
                        $ruta_imagen = '../admin/mantenedores/accesorios/' . $foto['foto_accesorio'];
                        echo "<div class='carousel-item $active'>";
                        echo "<div class='d-block img-fluid' style='background-image: url($ruta_imagen); background-repeat: no-repeat; max-width: 100%; max-height: 200px;
                                 width: auto; object-fit: contain; background-position: center; height: 400px; border-radius: 15px 15px 0 0;'></div>";
                        echo "</div>";
                        $active = ""; // Solo la primera imagen es "active"
                    }
                    echo "</div>";
                    echo "<button class='carousel-control-prev' type='button' data-bs-target='#carousel{$sku_accesorio}' data-bs-slide='prev'>...</button>";
                    echo "<button class='carousel-control-next' type='button' data-bs-target='#carousel{$sku_accesorio}' data-bs-slide='next'>...</button>";
                    echo "</div>";
                
                    // Información del vehículo
                    echo "<div class='card-body mt-1 text-center py-2'>";
                    $precio_formateado = number_format($fila['precio_accesorio'], 0, ',', '.');
                    echo "<h5 class='card-title fs-6 text-dark fw-bold mb-2'>{$fila['nombre_accesorio']}</h5>";
                    echo "<p class='text-success fw-bold mb-2'>$ {$precio_formateado} CLP</p>";
                    echo "</div>"; // card-body
                
                    echo "</div>"; // card
                    echo "</a>";

                    echo "
                    <!-- Modal -->
                    <div class='modal fade' id='accesorioModal' tabindex='-1' aria-labelledby='accesorioModalLabel' aria-hidden='true'>
                      <div class='modal-dialog modal-dialog-centered modal-lg'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='accesorioModalLabel'>{$fila['nombre_accesorio']}</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                          </div>
                          <div class='modal-body' id='modalContent'>
                            
                          </div>
                          <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>";
                
                    echo "</div>";
                }
            ?>

            <script>
              // Capturamos el evento del clic en el enlace
              document.getElementById('openModal').addEventListener('click', function() {
                var id = this.getAttribute('data-id'); // Obtenemos el ID del accesorio

                // Hacemos la petición AJAX a accesorio.php
                fetch('accesorio.php?id=' + id)
                  .then(response => response.text())
                  .then(data => {
                    // Cargamos el contenido recibido dentro del modal
                    document.getElementById('modalContent').innerHTML = data;
                
                    // Mostramos el modal usando Bootstrap
                    var myModal = new bootstrap.Modal(document.getElementById('accesorioModal'));
                    myModal.show();
                  })
                  .catch(error => console.error('Error:', error));
              });
            </script>

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