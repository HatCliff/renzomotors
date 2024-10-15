<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Seguros</title>
</head>

<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Seguros</h1>
        <a href="crear_seguro.php" class="btn btn-success mb-3">Agregar Seguro</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Seguro</th>
                    <th>Descripción</th>
                    <th>Proveedor</th>
                    <th>Tipo de Cobertura</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //obtener y mostrar elementos del mantendor
                $resultado = mysqli_query($conexion, "SELECT s.*, p.nombre_proveedor, 
                                                     GROUP_CONCAT(c.nombre_tipo_cobertura SEPARATOR ', ') AS tipo_cobertura
                                                     FROM seguro s 
                                                     LEFT JOIN proveedor p ON s.id_proveedor = p.id_proveedor
                                                     LEFT JOIN seguro_cobertura sc ON s.id_seguro = sc.id_seguro
                                                     LEFT JOIN cobertura c ON sc.id_cobertura = c.id_cobertura
                                                     GROUP BY id_seguro");
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id_seguro']}</td>
                            <td>{$fila['nombre_seguro']}</td>
                            <td>{$fila['descripcion_seguro']}</td>
                            <td>{$fila['nombre_proveedor']}</td>
                            <td>{$fila['tipo_cobertura']}</td>
                            <td>{$fila['precio_seguro']}</td>
                            <td>
                                <a href='editar_seguro.php?id={$fila['id_seguro']}' class='btn btn-primary'>Editar</a>
                                <a href='eliminar_seguro.php?id={$fila['id_seguro']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar este seguro?\");'>Eliminar</a>
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