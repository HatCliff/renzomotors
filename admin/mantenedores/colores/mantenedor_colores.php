<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Colores</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Mantenedor de Colores</h1>
        <a href="crear_color.php" class="btn btn-success mb-3">Agregar Color</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Color</th>
                    <th>Visualización</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //obtener y mostrar los elementos del mantenedor
                $colores = mysqli_query($conexion, "SELECT * FROM colores");
                while ($color = mysqli_fetch_assoc($colores)) {
                    echo "<tr>
                        <td>{$color['id_color']}</td>
                        <td>{$color['nombre_color']}</td>
                        <td style='background-color: {$color['codigo_color']}; width: 50px; height: 20px;'></td>
                        <td>
                            <a href='editar_color.php?id_color={$color['id_color']}' class='btn btn-primary btn-sm'>Editar</a>
                            <a href='eliminar_color.php?id_color={$color['id_color']}' class='btn btn-danger btn-sm' onclick=\"return confirm('¿Estás seguro de eliminar este color?')\">Eliminar</a>
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
