<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../../config/conexion.php');

if (isset($_GET['sku'])) {
    $sku = $_GET['sku']; // Obtener el sku del accesorio
    if(isset($_SESSION['usuario'])){
        $rut_user = $_SESSION['rut'];
    }

    // Realizar la consulta para obtener los detalles del accesorio
    $query = "SELECT * FROM accesorio a
            JOIN pertenece_tipo pt ON a.sku_accesorio = pt.sku_accesorio
            JOIN tipo_accesorio ta ON ta.id_tipo_accesorio = pt.id_tipo_accesorio 
            WHERE a.sku_accesorio = '$sku'";

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

        echo "</div><div class='carousel-inner' style='max-height: 50vh'>";

        $index = 0;
        // Generar elementos del carrusel dinámicos
        while ($foto = mysqli_fetch_assoc($fotos_resultado)) {
            $ruta_imagen = '../../admin/mantenedores/accesorios/' . $foto['foto_accesorio'];
            $active = $index === 0 ? 'active' : '';
            echo "<div class='carousel-item $active' style='border: 0.1em solid grey;'>";
            echo "<img src='$ruta_imagen' class='d-block w-100' alt='Foto accesorio' style='object-fit: cover; height: 100%; width: 100%';>";
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
                <h2><strong>" . $fila['nombre_accesorio'] . "</strong></h2>
                <p class='fw-bold mb-2''style='color:#3c4043'><strong>Precio:</strong> $" . number_format($fila['precio_accesorio'], 0, ',', '.') . " CLP</p>
                <p><strong>Descripción: </strong>" . $fila['descripcion_accesorio'] . "</p>
                <p><strong>Categoria: </strong>" . $fila['nombre_tipo_accesorio'] ."</p>
                <p><strong>Stock en linea: </strong>" . $fila['stock_accesorio'] ." unidades</p>";
                

                if (isset($_SESSION['usuario'])) {
                    $estado = "SELECT sku_accesorio FROM carrito_accesorio WHERE id_carrito = (SELECT id_carrito FROM carrito_usuario WHERE rut_usuario = '$rut_user')";
                    $estado_result = mysqli_query($conexion, $estado);
                    $item_list = [];
                    while ($item = mysqli_fetch_assoc($estado_result)) {
                        $item_list[] = $item['sku_accesorio'];
                    }
                    if(!in_array($sku, $item_list)){
                        echo "
                        <div class='d-grid mt-2 p-5'>
                            <a href='funciones_carrito/agregar_item.php?sku={$fila['sku_accesorio']}' type='button' class='btn btn-outline-primary'>Añadir a mi carrito</a>
                        </div>";
                    }else{
                        echo "
                        <div class='d-grid mt-2 p-5'>
                            <button type='button' class='btn btn-success disabled'>Accesorio ya agregado al carrito</a>
                        </div>";
                    }
                } else {
                    echo "
                    <div class='d-grid mt-2 p-5'>
                        <button type='button' class='btn btn-outline-primary disabled' data-bs-dismiss='modal'>Inicia Sesíon para usar el carrito</button>
                    </div>";
                }
                
    echo"   </div>
        </div>";
    } else {
        echo "<p>Accesorio no encontrado.</p>";
    }
}
?>