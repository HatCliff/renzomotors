<?php
session_start();
// Verificación de usuario
if (!isset($_SESSION['tipo_persona']) || !in_array($_SESSION['tipo_persona'], ['administrador', 'usuario'])) {
    header("Location: ../pages/login.php");
    exit();
}

// Incluye el navbar correspondiente según el tipo de usuario
if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
    include '../admin/navbaradmin.php';
} else {
    include '../components/navbaruser.php';
}
include('../config/conexion.php');

// Inicializamos el valor de la sucursal seleccionada
$id_sucursal = isset($_POST['id_sucursal']) ? $_POST['id_sucursal'] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Arriendo de Vehículo</title>
    <style>
        body {
            background: #E6E6E6;
        }
    </style>
</head>

<body class="pt-5">
    <div class="container mt-5">
        <div class="col-md-12">
            <div class="row mb-4">
                <h1 class="mb-2">Bienvenido</h1>
                <h1 class="mb-2">Seleccione Sucursal</h1>
                
                <!-- Formulario para seleccionar la sucursal -->
                <form id="sucursal-form" method="POST">
                    <div class='mb-3'>
                        <label for='id_sucursal' class='form-label'>Disponible en: </label>
                        <select id="id_sucursal" class='form-select' name='id_sucursal' required onchange="this.form.submit()">
                            <option value="">Seleccionar Sucursal</option>
                            <?php
                            // Cargar las sucursales disponibles
                            $disponible = mysqli_query($conexion, "SELECT su.id_sucursal, su.nombre_sucursal FROM sucursal su");
                            while ($disp = mysqli_fetch_assoc($disponible)) {
                                echo '<option value="' . $disp['id_sucursal'] . '"' . ($disp['id_sucursal'] == $id_sucursal ? ' selected' : '') . '>' . $disp['nombre_sucursal'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </form>

                <div id="vehicle-list">
                    <?php
                    // Si se ha seleccionado una sucursal, ejecutamos la consulta de vehículos
                    if ($id_sucursal) {
                        // Consulta de vehículos disponibles en la sucursal seleccionada
                        $query_vehiculos = "SELECT v.id_vehiculo, v.nombre_modelo, m.nombre_marca, a.anio, p.nombre_pais AS pais, 
                                            t.nombre_transmision AS transmision, v.kilometraje, c.nombre_tipo_combustible AS tipo_combustible,
                                            v.estado_vehiculo, v.precio_modelo
                                            FROM vehiculo v
                                            JOIN marca m ON v.id_marca = m.id_marca
                                            JOIN anio a ON v.id_anio = a.id_anio
                                            JOIN pais p ON v.id_pais = p.id_pais
                                            JOIN transmision t ON v.id_transmision = t.id_transmision
                                            JOIN tipo_combustible c ON v.id_tipo_combustible = c.id_tipo_combustible
                                            JOIN vehiculo_sucursal vs ON v.id_vehiculo = vs.id_vehiculo
                                            WHERE vs.id_sucursal = $id_sucursal AND v.cantidad_vehiculo > 0 AND v.arriendo= 1 AND vs.unidades_arriendo > 0";
                        
                        $result_vehiculos = mysqli_query($conexion, $query_vehiculos);

                        if (mysqli_num_rows($result_vehiculos) > 0) {
                            echo "<h2>Vehículos Disponibles en esta Sucursal</h2>";
                            echo "<div class='row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4'>";

                            
                            
                            while ($fila = mysqli_fetch_assoc($result_vehiculos)) {

                                    // Verificación si los datos existen
                                $estado_vehiculo = isset($fila['estado_vehiculo']) ? $fila['estado_vehiculo'] : 'Desconocido';
                                $precio_modelo = isset($fila['precio_modelo']) && $fila['precio_modelo'] !== null ? number_format($fila['precio_modelo'], 0, ',', '.') : 'No disponible';
                                $pais = isset($fila['pais']) ? $fila['pais'] : 'Desconocido';

                                
                                echo "<div class='col-12 col-sm-6 col-md-4 mb-4 d-flex align-items-stretch'>";
                                echo "<a href='arriendo_completado.php?id={$fila['id_vehiculo']}&sucursal={$id_sucursal}' class='text-decoration-none w-100'>";
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
                                echo "<p class='text-success fw-bold mb-2'>{$fila['anio']}</p>";
                                echo "<p class='text-muted mb-2'>{$fila['pais']}</p>";
                                echo "<p class='text-muted mb-2'>{$fila['transmision']}</p>";
                                echo "<p class='text-muted mb-2'>{$fila['kilometraje']}</p>";
                                echo "<p class='text-muted mb-2'>{$fila['tipo_combustible']}</p>";
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
                            echo "</div>";
                        } else {
                            echo "<p class='fst-italic'>No hay vehículos disponibles en esta sucursal.</p>";
                        }
                    } else {
                        echo "<p>Por favor selecciona una sucursal para ver los vehículos disponibles.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
