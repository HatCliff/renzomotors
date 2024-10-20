<?php
<<<<<<< HEAD
<<<<<<< HEAD
include '../conexion.php';
include '../navbar.php';
=======
include '../../../config/conexion.php';
include '../../navbaradmin.php';
>>>>>>> fmunozi
=======
include '../../../config/conexion.php';
include '../../navbaradmin.php';
>>>>>>> origin/macarrascoa
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Tipos de Ruedas</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Tipos de Ruedas</h1>
        <a href="crear_tipo_ruedas.php" class="btn btn-success mb-3">Agregar Tipo de Ruedas</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Ruedas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //consultar los datos del mantenedor
                $resultado = mysqli_query($conexion, "SELECT * FROM tipo_rueda");
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id_tipo_rueda']}</td>
                            <td>{$fila['nombre_tipo_rueda']}</td>
                            <td>
                                <a href='editar_tipo_ruedas.php?id={$fila['id_tipo_rueda']}' class='btn btn-primary'>Editar</a>
                                <a href='eliminar_tipo_ruedas.php?id={$fila['id_tipo_rueda']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar esta sucursal?\");'>Eliminar</a>
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
