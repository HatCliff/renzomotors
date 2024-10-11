<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Tipo de Vehiculos</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Tipo de Vehiculos</h1>
        <a href="crear_tipo_vehiculo.php" class="btn btn-success mb-3">Agregar Tipo de vehiculo</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    
                    <th>ID</th>
                    <th>Tipo Vehiculo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //consultar los datos del mantenedor
                $resultado = mysqli_query($conexion, "SELECT * FROM tipo_vehiculo");
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id_tipo_vehiculo']}</td>
                            <td>{$fila['nombre_tipo_vehiculo']}</td>
                            <td>
                                <a href='editar_tipo_vehiculo.php?id_tipo_vehiculo={$fila['id_tipo_vehiculo']}' class='btn btn-primary'>Editar</a>
                                <a href='eliminar_tipo_vehiculo.php?id_tipo_vehiculo={$fila['id_tipo_vehiculo']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar este tipo de vehiculo?\");'>Eliminar</a>
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
