<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../../config/conexion.php'); 

if (isset($_GET['sku'])) {
    $sku = $_GET['sku']; // Obtener el sku del accesorio

    // Realizar la consulta para obtener los detalles del accesorio
    $query = "SELECT * FROM accesorio WHERE sku_accesorio = '$sku'";
    $resultado = mysqli_query($conexion, $query);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<div class='row'>
            <div class='col-6'>";
        echo "<div id='carouselExampleIndicators' class='carousel slide'>";
        echo "<div class='carousel-indicators'>";
        
        $sku_accesorio = $fila['sku_accesorio'];
        $fotos_resultado = mysqli_query($conexion, "SELECT foto_accesorio FROM fotos_accesorio WHERE sku_accesorio = '$sku_accesorio'");
        $index = 0;
        
        // Generar indicadores dinámicos
        while ($foto = mysqli_fetch_assoc($fotos_resultado)) {
            $active = $index === 0 ? 'active' : '';
            echo "<button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='$index' class='$active' aria-label='Slide " . ($index + 1) . "'></button>";
            $index++;
        }
        
        // Reiniciar el puntero para reutilizar el resultado de la consulta
        mysqli_data_seek($fotos_resultado, 0);
        
        echo "</div>
              <div class='carousel-inner' style='max-height: 50vh'>";
        
        $index = 0;
        // Generar elementos del carrusel dinámicos
        while ($foto = mysqli_fetch_assoc($fotos_resultado)) {
            $ruta_imagen = '../../admin/mantenedores/accesorios/' . $foto['foto_accesorio'];
            $active = $index === 0 ? 'active' : '';
            echo "<div class='carousel-item $active'>";
            echo "<img src='$ruta_imagen' class='d-block w-100' alt='Foto accesorio' style='object-fit: cover; height: 100%; width: 100%'>";
            echo "</div>";
            $index++;
        }
        
        echo "</div>
            <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide='prev'>
            <span class='carousel-control-prev-icon' aria-hidden='true'></span>
            <span class='visually-hidden'>Previous</span>
            </button>
            <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide='next'>
            <span class='carousel-control-next-icon' aria-hidden='true'></span>
            <span class='visually-hidden'>Next</span>
            </button>
            </div>
            </div>
            <div class='col-6'>
                <h3>" . $fila['nombre_accesorio'] . "</h3>
                <p class='text-success'><strong>Precio:</strong> $" . number_format($fila['precio_accesorio'], 0, ',', '.') . " CLP</p>
                <p>" . $fila['descripcion_accesorio'] . "</p>
            </div>
        </div>";
    } else {
        echo "<p>Accesorio no encontrado.</p>";
    }
}
?>