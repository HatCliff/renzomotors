<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Accesorios</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Mantenedor de Accesorios</h1>
        <a href="crear_accesorio.php" class="btn btn-success mb-3">Agregar Accesorio</a>
        <a href="../index.php" class="btn btn-success mb-3">Volver Inicio</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
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
                    <td><?php echo $accesorio['sku_accesorio']; ?></td>
                    <td><?php echo $accesorio['nombre_accesorio']; ?></td>
                    <td><?php echo $accesorio['precio_accesorio']; ?></td>
                    <td><?php echo $accesorio['stock_accesorio']; ?></td>
                    <td><?php echo $accesorio['descripcion_accesorio']; ?></td>
                    <td>
                        <?php
                        // Obtener fotos del accesorio
                        $resultado_fotos = mysqli_query($conexion, "SELECT * FROM fotos_accesorio WHERE sku_accesorio = '$sku'");
                        while ($foto = mysqli_fetch_assoc($resultado_fotos)) {
                            echo "<img src='{$foto['foto_accesorio']}' alt='Foto accesorio' width='100px' height='100px' class='img-thumbnail me-2'>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        // Obtener tipos de accesorio asociados
                        $query= "SELECT ta.nombre_tipo_accesorio 
                        FROM tipo_accesorio ta
                        INNER JOIN pertenece_tipo pt ON ta.id_tipo_accesorio = pt.id_tipo_accesorio
                        WHERE pt.sku_accesorio = '$sku'";
                        $resultado_tipos = mysqli_query($conexion,$query);
                        while ($tipo = mysqli_fetch_assoc($resultado_tipos)) {
                            echo $tipo['nombre_tipo_accesorio'] . '<br>';
                        }
                        ?>
                    </td>
                    <td>
                        <a href="editar_accesorio.php?sku=<?php echo $accesorio['sku_accesorio']; ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="eliminar_accesorio.php?sku=<?php echo $accesorio['sku_accesorio']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este accesorio?')">Eliminar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
