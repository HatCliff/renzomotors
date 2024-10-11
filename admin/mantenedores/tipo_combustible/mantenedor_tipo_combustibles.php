<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Tipo de Combustible</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Combustibles</h1>
        <a href="crear_tipo_combustible.php" class="btn btn-success mb-3">Agregar Tipo de Combustible</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Combustible</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //mostrar todos los datos del mantendor
                $resultado = mysqli_query($conexion, "SELECT * FROM tipo_combustible");
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id_tipo_combustible']}</td>
                            <td>{$fila['nombre_tipo_combustible']}</td>
                            <td>
                                <a href='editar_tipo_combustible.php?id_tipo_combustible={$fila['id_tipo_combustible']}' class='btn btn-primary'>Editar</a>
                                <a href='eliminar_tipo_combustible.php?id_tipo_combustible={$fila['id_tipo_combustible']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar este tipo de Combustible?\");'>Eliminar</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
