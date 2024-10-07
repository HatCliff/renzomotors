<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Servicios</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Servicios</h1>
        <a href="crear_servicio.php" class="btn btn-success mb-3">Agregar Servicio</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Servicio</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Sucursales Disponibles</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //obtener y mostrar los elemetos del matenendor
                $query = "SELECT s.*, GROUP_CONCAT(sc.nombre_sucursal SEPARATOR ', ') AS sucursales 
                          FROM servicios s 
                          LEFT JOIN servicio_sucursal ss ON s.id_servicio = ss.id_servicio 
                          LEFT JOIN sucursales sc ON ss.id_sucursal = sc.id_sucursal
                          GROUP BY s.id_servicio";
                $resultado = mysqli_query($conexion, $query);

                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id_servicio']}</td>
                            <td>{$fila['nombre_servicio']}</td>
                            <td>{$fila['descripcion']}</td>
                            <td>{$fila['precio_servicio']}</td>
                            <td>{$fila['sucursales']}</td>
                            <td>
                                <a href='editar_servicio.php?id={$fila['id_servicio']}' class='btn btn-primary'>Editar</a>
                                <a href='eliminar_servicio.php?id={$fila['id_servicio']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar este servicio?\");'>Eliminar</a>
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
