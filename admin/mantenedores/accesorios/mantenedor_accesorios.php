<?php
include '../conexion.php';
include '../navbar.php';
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
                    <th>Fotos</th>
                    <th>Tipos de Accesorio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                //obtener y mostrar los elementos del mantenedor

                $resultado = mysqli_query($conexion, "SELECT * FROM accesorios");
                while ($accesorio = mysqli_fetch_assoc($resultado)) {
                    $sku = $accesorio['sku'];
                ?>
                <tr>
                    <td><?php echo $accesorio['sku']; ?></td>
                    <td><?php echo $accesorio['nombre']; ?></td>
                    <td><?php echo $accesorio['precio']; ?></td>
                    <td><?php echo $accesorio['stock']; ?></td>
                    <td><?php echo $accesorio['descripcion']; ?></td>
                    <td>
                        <?php
                        // Obtener fotos del accesorio
                        $resultado_fotos = mysqli_query($conexion, "SELECT * FROM fotos_accesorio WHERE sku_accesorio = '$sku'");
                        while ($foto = mysqli_fetch_assoc($resultado_fotos)) {
                            echo "<img src='{$foto['foto']}' alt='Foto accesorio' width='100' height='100' class='img-thumbnail me-2'>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        // Obtener tipos de accesorio asociados
                        $query= "SELECT ta.nombre_tipo_accesorio 
                        FROM tipos_accesorios ta
                        INNER JOIN accesorio_tipo at ON ta.id_tipo_accesorio = at.id_tipo_accesorio
                        WHERE at.sku_accesorio = '$sku'";
                        $resultado_tipos = mysqli_query($conexion,$query);
                        while ($tipo = mysqli_fetch_assoc($resultado_tipos)) {
                            echo $tipo['nombre_tipo_accesorio'] . '<br>';
                        }
                        ?>
                    </td>
                    <td>
                        <a href="editar_accesorio.php?sku=<?php echo $accesorio['sku']; ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="eliminar_accesorio.php?sku=<?php echo $accesorio['sku']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este accesorio?')">Eliminar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
