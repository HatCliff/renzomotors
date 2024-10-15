<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Años</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Años</h1>
        <a href="crear_anio.php" class="btn btn-success mb-3">Agregar Año</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Año</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //obtener y mostrar los elementos del mantenedor
                $resultado = mysqli_query($conexion, "SELECT * FROM anios");
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id_anio']}</td>
                            <td>{$fila['anio']}</td>
                            <td>
                                <a href='editar_anio.php?id_anio={$fila['id_anio']}' class='btn btn-primary'>Editar</a>
                                <a href='eliminar_anio.php?id_anio={$fila['id_anio']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar este año?\");'>Eliminar</a>
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
