<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Promociones</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Promociones</h1>
        <a href="crear_promocion.php" class="btn btn-success mb-3">Agregar Promocion</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Icono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //obtener y mostrar los elementos del mantenedor
                $resultado = mysqli_query($conexion, "SELECT * FROM promocion_especial");
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id_promocion']}</td>
                            <td>{$fila['nombre_promocion']}</td>
                            <td>{$fila['descripcion_promocion']}</td>
                            <td><img src='icono_promo/{$fila['icono_promocion']}' alt='Logo' width='50'></td>
                            <td>
                                <a href='editar_promocion.php?id_promocion={$fila['id_promocion']}' class='btn btn-primary'>Editar</a>
                                <a href='eliminar_promocion.php?id_promocion={$fila['id_promocion']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar esta promocion?\");'>Eliminar</a>
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
