<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Permisos</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Permisos</h1>
        <a href="crear_permiso.php" class="btn btn-success mb-3">Agregar Permiso</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Permiso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //obtener y mostrar elementos del mantenedor
                $query = "SELECT * FROM permisos";
                $resultado = mysqli_query($conexion, $query);

                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id_permiso']}</td>
                            <td>{$fila['nombre_permiso']}</td>
                            <td>
                                <a href='editar_permiso.php?id_permiso={$fila['id_permiso']}' class='btn btn-primary'>Editar</a>
                                <a href='eliminar_permiso.php?id_permiso={$fila['id_permiso']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar este permiso?\");'>Eliminar</a>
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
