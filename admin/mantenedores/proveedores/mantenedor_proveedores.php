<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';

// Obtener todos los proveedores
$query = "SELECT * FROM proveedores_seguro";
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenedor de Proveedores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<!DOCTYPE html>
<html lang="es">

<body class="pt-5">
    <div class="container">
        <h2 class="mt-5">Mantenedor de Proveedores</h2>
        <a href="crear_proveedor.php" class="btn btn-success mb-3">Agregar Proveedor</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Proveedor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- mostrar los elementos del mantendor -->
                <?php while ($proveedor = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo $proveedor['id_proveedor']; ?></td>
                        <td><?php echo $proveedor['nombre_proveedor']; ?></td>
                        <td>
                            <a href="editar_proveedor.php?id=<?php echo $proveedor['id_proveedor']; ?>" class="btn btn-primary">Editar</a>
                            <a href="eliminar_proveedor.php?id=<?php echo $proveedor['id_proveedor']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este proveedor?');">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
