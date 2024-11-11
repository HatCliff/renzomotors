<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Accesorios</title>

    <style>
        .carousel-inner .carousel-item img {
            .carousel-inner {
                width: 200px;
                /* Asegura el ancho máximo del carrusel */
                max-height: 100px;
                /* Asegura que la altura máxima no se supere */
                overflow: hidden;
                /* Oculta cualquier exceso de imagen */
            }

            .carousel-inner .carousel-item img {
                max-width: 100%;
                /* Asegura que la imagen no se extienda más allá del ancho */
                max-height: 100px;
                /* Limita la altura de la imagen */
                width: auto;
                /* Mantiene la relación de aspecto */
                object-fit: contain;
                /* Ajusta la imagen dentro del contenedor sin deformarla */
            }
        }
    </style>
</head>

<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Mantenedor de Accesorios</h1>
        <a href="crear_accesorio.php" class="btn btn-success mb-3">Agregar Accesorio</a>
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width: 300px;">Accesorio</th>
                    <th>Descripción</th>
                    <th>Imagenes</th>
                    <th>Tipos de Accesorio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php

                //obtener y mostrar los elementos del mantenedor
                
                $resultado = mysqli_query($conexion, "SELECT * FROM accesorio");
                while ($accesorio = mysqli_fetch_assoc($resultado)) {
                    $sku = $accesorio['sku_accesorio'];
                    ?>
                    <tr>
                        <td>
                            <?php 
                            echo "<span class='text-primary fw-bold'>{$accesorio['sku_accesorio']}</span> - {$accesorio['nombre_accesorio']}"; 
                            echo "<br>";
                            echo "<span>Stock: {$accesorio['stock_accesorio']}</span><br>";
                            echo "<span>Precio: {$accesorio['precio_accesorio']}</span>";
                            ?>
                        </td>
                        <td><?php echo $accesorio['descripcion_accesorio']; ?></td>
                        <td>
                        <?php
                        echo "<div id='carousel-{$accesorio['sku_accesorio']}' class='carousel slide d-flex align-items-center' data-bs-ride='carousel' style='width: 200px; max-height: 100px;'>
                                <div class='carousel-inner' style='width: 200px; max-height: 100px; overflow: hidden;'>";
                            $sku_accesorio = $accesorio['sku_accesorio'];
                            $fotos_resultado = mysqli_query($conexion, "SELECT foto_accesorio FROM fotos_accesorio WHERE sku_accesorio= '$sku_accesorio'");
                            $active_class = "active";
                            while ($foto = mysqli_fetch_assoc($fotos_resultado)) {
                                echo "<div class='carousel-item $active_class'>
                                        <img src='{$foto['foto_accesorio']}' alt='Foto accesorio' class='d-block w-100 img-fluid' style='max-width: 100%; max-height: 100px; width: auto; object-fit: contain;'>
                                      </div>";
                                $active_class = "";
                            }
                            echo "    </div>
                                <button class='carousel-control-prev' type='button' data-bs-target='#carousel-{$accesorio['sku_accesorio']}' data-bs-slide='prev'>
                                    <span class='carousel-control-prev-icon'></span>
                                    <span class='visually-hidden'>Anterior</span>
                                </button>
                                <button class='carousel-control-next' type='button' data-bs-target='#carousel-{$accesorio['sku_accesorio']}' data-bs-slide='next'>
                                    <span class='carousel-control-next-icon'></span>
                                    <span class='visually-hidden'>Siguiente</span>
                                </button>
                            </div>";
                        ?>
                        </td>
                        <td>
                            <?php
                            // Obtener tipos de accesorio asociados
                            $query = "SELECT ta.nombre_tipo_accesorio 
                        FROM tipo_accesorio ta
                        INNER JOIN pertenece_tipo pt ON ta.id_tipo_accesorio = pt.id_tipo_accesorio
                        WHERE pt.sku_accesorio = '$sku'";
                            $resultado_tipos = mysqli_query($conexion, $query);
                            while ($tipo = mysqli_fetch_assoc($resultado_tipos)) {
                                echo "- ";
                                echo $tipo['nombre_tipo_accesorio'] . '<br>';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="editar_accesorio.php?sku=<?php echo $accesorio['sku_accesorio']; ?>"
                                class="btn btn-primary btn-sm">Editar</a>
                            <a href="eliminar_accesorio.php?sku=<?php echo $accesorio['sku_accesorio']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Estás seguro de eliminar este accesorio?')">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>