<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Tipos de Pago</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Tipos de Pagos</h1>
        <a href="crear_tipo_pago.php" class="btn btn-success mb-3">Agregar Tipo de Pago</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Pago</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //consultar los datos del mantenedor
                $resultado = mysqli_query($conexion, "SELECT * FROM tipos_pago");
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id_tipo_pago']}</td>
                            <td>{$fila['nombre']}</td>
                            <td>
                                <a href='editar_tipo_pago.php?id={$fila['id_tipo_pago']}' class='btn btn-primary'>Editar</a>
                                <a href='eliminar_tipo_pago.php?id={$fila['id_tipo_pago']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar esta sucursal?\");'>Eliminar</a>
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
