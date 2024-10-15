<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Sucursales</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Sucursales</h1>
        <a href="crear_sucursal.php" class="btn btn-success mb-3">Agregar Sucursal</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Sucursal</th>
                    <th>Encargado</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //obtener y mostrar datos del mantenedor
                $resultado = mysqli_query($conexion, "SELECT * FROM sucursal");
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id_sucursal']}</td>
                            <td>{$fila['nombre_sucursal']}</td>
                            <td>{$fila['encargado_sucursal']}</td>
                            <td>{$fila['direccion_sucursal']}</td>
                            <td>
                                <a href='editar_sucursal.php?id={$fila['id_sucursal']}' class='btn btn-primary'>Editar</a>
                                <a href='eliminar_sucursal.php?id={$fila['id_sucursal']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar esta sucursal?\");'>Eliminar</a>
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
