<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Marcas</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Marcas</h1>
        <a href="crear_marca.php" class="btn btn-success mb-3">Agregar Marca</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Logo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //obtener y mostrar los elementos del mantenedor
                $resultado = mysqli_query($conexion, "SELECT * FROM marca");
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id_marca']}</td>
                            <td>{$fila['nombre_marca']}</td>
                            <td>{$fila['descripcion_marca']}</td>
                            <td><img src='logos/{$fila['logo_marca']}' alt='Logo' width='50'></td>
                            <td>
                                <a href='editar_marca.php?id_marca={$fila['id_marca']}' class='btn btn-primary'>Editar</a>
                                <a href='eliminar_marca.php?id_marca={$fila['id_marca']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar esta marca?\");'>Eliminar</a>
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
