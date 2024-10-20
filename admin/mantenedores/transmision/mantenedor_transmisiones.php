<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Transmisiones</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Transmisiones</h1>
        <a href="crear_transmision.php" class="btn btn-success mb-3">Agregar Transmisión</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Transmisión</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta para obtener todos los datos del mantendeor 
                $resultado = mysqli_query($conexion, "SELECT * FROM transmision");
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    // Mostrar los datos del mantenedor
                    echo "<tr>
                            <td>{$fila['id_transmision']}</td>
                            <td>{$fila['nombre_transmision']}</td>
                            <td>
                                <a href='editar_transmision.php?id_transmision={$fila['id_transmision']}' class='btn btn-primary'>Editar</a>
                                <a href='eliminar_transmision.php?id_transmision={$fila['id_transmision']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar esta transmisión?\");'>Eliminar</a>
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
