<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../../config/conexion.php'); 

$orden = $_POST['orden'] ?? '';
$id_tipo_accesorio = $_POST['id_tipo_accesorio'] ?? [];
$nombre_accesorio = $_POST['modelo_i'] ?? ''; 

$query = "SELECT DISTINCT a.*, nombre_tipo_accesorio
          FROM accesorio a
          JOIN pertenece_tipo pt ON a.sku_accesorio = pt.sku_accesorio
          JOIN tipo_accesorio ta ON ta.id_tipo_accesorio = pt.id_tipo_accesorio
          WHERE a.stock_accesorio != 0
          GROUP BY a.sku_accesorio";

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
    include '../../admin/navbaradmin.php';
} else {
    // Usuario es normal, incluye el navbar de usuario
    include '../../components/navbaruser.php';
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
                            url('../../src/images/accesorios-banner.jpg'); 
            background-size: cover;
            background-position: center 70%  ;
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
<body class="pt-5 mt-5">
    <div class="container banner">
        <h1 class="text-white">Encuentra el Auto de tus Sueños en RenzoMotors.</h1>
        <h2>Usa nuestro buscador para ver todos nuestros modelos, conoce los precios y características de los mejores vehículos.</h2>
    </div>
    <div class="container mt-2 mb-5">
        <div class="row mb-4">
            <div class="col-6 ps-0">
                <form id="filtroForm" method="POST" enctype="multipart/form-data">
                    <input class="form-control" type="text" name="accesorio_i" placeholder="Ejemplo: Limpiador de ruedas" aria-label="Nombre del accesorio" value="<?php echo htmlspecialchars($nombre_accesorio); ?>"
                    onchange="document.getElementById('filtroForm').submit()">
                    <button type="submit" style="display: none;"></button>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <!-- Carrito -->
                <?php
                    if (isset($_SESSION['usuario'])){?>
                        <a href="carrito_accesorio.php">
                            <div class="mx-2 d-flex justify-content-center align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="carrito" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                </svg>
                            </div>
                        </a>
                <?php }
                    else{?>
                        <a href="#" title="Inicia Sesíon para acceder al carrito">
                            <div class="mx-2 d-flex justify-content-center align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="carrito" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                </svg>
                            </div>
                        </a>
                    <?php }
                ?> 
            </div>
        </div>

        <div class='alert alert-warning alert-container mt-2'id='alerta_datos' role='alert' style='display: none;'>
            ¡No se encontraron resultados!
        </div>
        <!-- buscador y filtros -->
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
                            <!-- Contenido de Categoria -->
                            <div class="accordion-item me-1">
                                <h2 class="accordion-header" id="headingCategoria">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseCategoria" aria-expanded="false" aria-controls="collapseCategoria">
                                        Categoría
                                    </button>
                                </h2>
                                <div id="collapseCategoria" class="accordion-collapse collapse" aria-labelledby="headingCategoria"
                                        data-bs-parent="#accordionFiltros">
                                        <div class="accordion-body">
                                            <ul class="no-style">
                                                <?php
                                                    $consulta = mysqli_query($conexion, "SELECT * FROM tipo_accesorio");
                                                    while ($row = mysqli_fetch_assoc($consulta)) {
                                                        $isChecked = in_array($row['id_tipo_accesorio'], $id_tipo_accesorio) ? 'checked' : '';
                                                        echo "<li class='accordion-item'>";
                                                        echo "<label>";
                                                        echo "<input type='checkbox' name='id_tipo_accesorio[]' 
                                                            value='{$row['id_tipo_accesorio']}' $isChecked 
                                                            onchange='document.getElementById(\"filtroForm\").submit()'>";
                                                        echo "  {$row['nombre_tipo_accesorio']}";
                                                        echo "</label>";
                                                        echo "</li>";
                                                    }
                                                ?>
                                            </ul>                                        
                                        </div>
                                    </div>
                            </div>
                            <!-- Contenido de Ordenar por -->
                            <div class="accordion-item me-1">
                                <h2 class="accordion-header" id="headingOrdenar">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOrdenar" aria-expanded="false" aria-controls="collapseOrdenar">
                                        Ordenar por
                                    </button>
                                </h2>
                                <div id="collapseOrdenar" class="accordion-collapse collapse" aria-labelledby="headingOrdenar"
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

                        </div>

                        <!-- Limpiar filtros -->
                        <div class="d-flex gap-2 mt-3 mb-4 d-flex justify-content-center">
                            <button type="submit" name="Limpiar" id="Limpiar" class="btn mt-4" style="background: #c0c0c0;">Limpiar Filtros</button>
                        </div>
                    </div>
                </div>

                <!-- buscador y filtros -->
                <div class="col-lg-2 col-12  d-none d-lg-block" style="background: #fffcf4; border-radius: 20px; border: 0.1em solid grey;">
                    <h3 class="mb-4 mt-3 d-flex justify-content-center">Filtros</h3>

                    <div class="col d-flex flex-column mt-3" >
                        <div class="accordion">
                            <!-- Contenido de Categoria -->
                            <div class="accordion-item me-1">
                                <h2 class="accordion-header" id="headingCategoria">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseCategoria" aria-expanded="false" aria-controls="collapseCategoria">
                                        Categoría
                                    </button>
                                </h2>
                                <div id="collapseCategoria" class="accordion-collapse collapse" aria-labelledby="headingCategoria"
                                    data-bs-parent="#accordionFiltros">
                                    <div class="accordion-body">
                                        <ul class="no-style">
                                            <?php
                                                $consulta = mysqli_query($conexion, "SELECT * FROM tipo_accesorio");
                                                while ($row = mysqli_fetch_assoc($consulta)) {
                                                    $isChecked = in_array($row['id_tipo_accesorio'], $id_tipo_accesorio) ? 'checked' : '';
                                                    echo "<li class='accordion-item'>";
                                                    echo "<label>";
                                                    echo "<input type='checkbox' name='id_tipo_accesorio[]' 
                                                        value='{$row['id_tipo_accesorio']}' $isChecked 
                                                        onchange='document.getElementById(\"filtroForm\").submit()'>";
                                                    echo "  {$row['nombre_tipo_accesorio']}";
                                                    echo "</label>";
                                                    echo "</li>";
                                                }
                                            ?>
                                        </ul>                                        
                                    </div>
                                </div>
                            </div>
                            <!-- Contenido de Ordenar por -->
                            <div class="accordion-item me-1">
                                <h2 class="accordion-header" id="headingOrdenar">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOrdenar" aria-expanded="false" aria-controls="collapseOrdenar">
                                        Ordenar por
                                    </button>
                                </h2>
                                <div id="collapseOrdenar" class="accordion-collapse collapse" aria-labelledby="headingOrdenar"
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
                        </div>
                    </div>

                    <!-- Limpiar filtros -->
                    <div class="d-flex gap-2 mt-3 mb-4 d-flex justify-content-center">
                        <button type="submit" name="Limpiar" id="Limpiar" class="btn mt-4" style="background: #c0c0c0;">Limpiar Filtros</button>
                    </div>
                    </form>
                </div> 
                <!-- Acessorio -->
                <div class="col-lg-10 col-12" id="accesorio-container">
                    <div class="row">
                        <?php 
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                echo "<div class='col-lg-3 col-md-4 col-sm-6 mb-3'>"; // 4 en lg, 3 en md, 2 en sm
                                echo "<a href='javascript:void(0);' class='text-decoration-none openModal' data-id='{$fila['sku_accesorio']}'>";
                                echo "<div class='card h-100 d-flex flex-column' style='max-height: 400px; background: #fffcf4; border-radius: 20px; overflow: hidden;'>";
                                
                                // Carrusel de fotos del accesorio
                                $sku_accesorio = $fila['sku_accesorio'];
                                $fotos_resultado = mysqli_query($conexion, "SELECT foto_accesorio FROM fotos_accesorio WHERE sku_accesorio = '$sku_accesorio'");
                                
                                echo "<div id='carousel{$sku_accesorio}' class='carousel slide' data-bs-ride='carousel'>";
                                echo "<div class='carousel-inner' style='height: 200px;'>"; 
                                $active = "active";
                                while ($foto = mysqli_fetch_assoc($fotos_resultado)) {
                                    $ruta_imagen = '../../admin/mantenedores/accesorios/' . $foto['foto_accesorio'];
                                    echo "<div class='carousel-item $active' style='background-color: #ffffff;'>
                                            <img class='d-block w-100 h-100' src='$ruta_imagen' alt='' style='object-fit: contain;'> <!-- Mostrar imagen completa -->
                                          </div>";
                                    $active = "";
                                }
                                echo "</div>";
                                echo "<button class='carousel-control-prev' type='button' data-bs-target='#carousel{$sku_accesorio}' data-bs-slide='prev'>
                                        <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                                        <span class='visually-hidden'>Previous</span>
                                      </button>";
                                echo "<button class='carousel-control-next' type='button' data-bs-target='#carousel{$sku_accesorio}' data-bs-slide='next'>
                                        <span class='carousel-control-next-icon' aria-hidden='true'></span>
                                        <span class='visually-hidden'>Next</span>
                                      </button>";
                                echo "</div>";
                                
                                // Información del accesorio
                                echo "<a href='javascript:void(0);' class='text-decoration-none openModal' data-id='{$fila['sku_accesorio']}'>";
                                $precio_formateado = number_format($fila['precio_accesorio'], 0, ',', '.');
                                echo "<div class='card-body mt-1 text-center py-3' style='position: relative; height: 150px;'>"; 
                                echo "<h5 class='card-title text-dark fw-bold mb-2'>{$fila['nombre_accesorio']}</h5>";
                                echo "<p class='fw-bold mb-2' style='color:#3c4043'>$ {$precio_formateado} CLP</p>";
                                echo "<p class='text-muted mb-2'>{$fila['nombre_tipo_accesorio']}</p>";
                                echo "</div>"; // card-body
                                
                                echo "</div>"; // card
                                echo "</a>";
                                
                                echo "
                                <!-- Modal -->
                                <div class='modal fade' id='accesorioModal' tabindex='-1' aria-labelledby='accesorioModalLabel' aria-hidden='true'>
                                <div class='modal-dialog modal-dialog-centered modal-lg'>
                                    <div class='modal-content' style='background: #E6E6E6;'>
                                    <div class='modal-header' style='border-bottom: none;'>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body' id='modalContent'>
                                    </div>
                                    </div>
                                </div>
                                </div>";
                            
                                echo "</div>";
                            }
                        ?>

                        <script>
                        // Capturamos el evento del clic en el enlace
                        document.querySelectorAll('.openModal').forEach(button => {
                            button.addEventListener('click', function() {
                                var sku = this.getAttribute('data-id'); // Obtenemos el ID del accesorio                

                                // Hacemos la petición AJAX a accesorio.php
                                fetch('accesorio.php?sku=' + sku)
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
                            });
                        </script>
                    </div>                          
                </div>
                <!-- termina accesorio -->
            </div>
        </div>
    </div>  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php
    include("../../components/footer.php")
?>
</html>

<script>
        // Mostrar la alerta si no hay resultados
        if (typeof showAlert !== 'undefined' && showAlert) {
            document.getElementById('alerta_datos').style.display = 'block';
        } else {
            document.getElementById('alerta_datos').style.display = 'none';
        }
</script>