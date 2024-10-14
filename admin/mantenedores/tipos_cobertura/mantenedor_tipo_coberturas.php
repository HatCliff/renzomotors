<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenedor de Tipos de Cobertura</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="pt-5">
    <div class="container">
        <h2 class="mt-5">Mantenedor de Tipos de Cobertura</h2>
        <a href="crear_tipo_cobertura.php" class="btn btn-success mb-3">Agregar Tipo de Cobertura</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Tipo de Cobertura</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        //consultar datos desde el mantenedor
                    $query = "SELECT * FROM cobertura";
                    $resultado = mysqli_query($conexion, $query);
                    while ($tipo = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?php echo $tipo['id_cobertura']; ?></td>
                        <td><?php echo $tipo['nombre_tipo_cobertura']; ?></td>
                        <td>
                            <a href="editar_tipo_cobertura.php?id=<?php echo $tipo['id_cobertura']; ?>" class="btn btn-primary">Editar</a>
                            <a href="eliminar_tipo_cobertura.php?id=<?php echo $tipo['id_cobertura']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este tipo de cobertura?');">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
