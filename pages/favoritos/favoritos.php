<?php
session_start();
include('../../config/conexion.php');

// Incluye el navbar correspondiente según el tipo de usuario
if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
    // Usuario es administrador, incluye el navbar de administrador
    include '../../admin/navbaradmin.php';
} else {
    // Usuario es normal, incluye el navbar de usuario
    include '../../components/navbaruser.php';
}
$rut = $_SESSION['rut'];

// Preparar la consulta usando declaraciones preparadas para mayor seguridad

$query = "SELECT v.*, m.nombre_marca, a.anio, p.nombre_pais
          FROM vehiculo v
          JOIN marca m ON v.id_marca = m.id_marca
          JOIN anio a ON v.id_anio = a.id_anio
          JOIN pais p ON v.id_pais = p.id_pais
          JOIN favoritos f ON v.id_vehiculo = f.id_vehiculo 
          WHERE f.id_usuario = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $rut); // Asume que el RUT es un string
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Vehículos Favoritos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="mt-5 pt-5">
<div class="container mt-5">
    <h1>Mis Vehículos Favoritos</h1>
    <div class="row">
        <?php while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "<div class='col-12 col-sm-6 col-md-4 mb-4 d-flex align-items-stretch'>";
    echo "<a href='../vehiculo.php?id={$fila['id_vehiculo']}' class='text-decoration-none w-100'>";
    echo "<div class='card h-100 d-flex flex-column' style='background: #fffcf4; border-radius: 20px; overflow: hidden;'>";

    // Carrusel de fotos del vehículo
    $id_vehiculo = $fila['id_vehiculo'];
    $fotos_resultado = mysqli_query($conexion, "SELECT ruta_foto FROM fotos_vehiculo WHERE id_vehiculo = $id_vehiculo");
    
    echo "<div id='carousel{$id_vehiculo}' class='carousel slide' data-bs-ride='carousel'>";
    echo "<div class='carousel-inner'>";
    $active = "active";
    while ($foto = mysqli_fetch_assoc($fotos_resultado)) {
        $ruta_imagen = '../../admin/mantenedores/vehiculo/' . $foto['ruta_foto'];
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
} ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
