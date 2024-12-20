<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Roles</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Roles</h1>
        <a href="crear_rol.php" class="btn btn-success mb-3">Agregar Rol</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Rol</th>
                    <th style="max-width: 400px">Permisos Asociados</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT r.*, GROUP_CONCAT(p.nombre_permiso SEPARATOR ', ') AS permiso 
                          FROM rol r 
                          LEFT JOIN rol_permiso rp ON r.id_rol = rp.id_rol 
                          LEFT JOIN permiso p ON rp.id_permiso = p.id_permiso
                          GROUP BY r.id_rol";
                $resultado = mysqli_query($conexion, $query);

                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id_rol']}</td>
                            <td>{$fila['nombre_rol']}</td>
                            <td>{$fila['permiso']}</td>
                            <td>
                                <a href='editar_rol.php?id_rol={$fila['id_rol']}' class='btn btn-primary'>Editar</a>
                                <a href='eliminar_rol.php?id_rol={$fila['id_rol']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar este rol?\");'>Eliminar</a>
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
