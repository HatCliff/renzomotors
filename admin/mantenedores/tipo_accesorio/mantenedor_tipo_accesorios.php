<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';


// Obtener todos los tipos de accesorios
$query = "SELECT * FROM tipo_accesorio";
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Tipos de Accesorios</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1>Mantenedor de Tipos de Accesorios</h1>
        <a href="crear_tipo_accesorio.php" class="btn btn-success mb-3">Crear Nuevo Tipo de Accesorio</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- mostrar los datos del mantenedor -->
                <?php while ($tipo = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo $tipo['id_tipo_accesorio']; ?></td>
                        <td><?php echo $tipo['nombre_tipo_accesorio']; ?></td>
                        <td>
                            <a href="editar_tipo_accesorio.php?id_tipo_accesorio=<?php echo $tipo['id_tipo_accesorio']; ?>" class="btn btn-primary">Editar</a>
                            <a href="eliminar_tipo_accesorio.php?id_tipo_accesorio=<?php echo $tipo['id_tipo_accesorio']; ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar este tipo de accesorio?')">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
