<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Países</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Países</h1>
        <a href="crear_pais.php" class="btn btn-success mb-3">Agregar País</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //obtener y mostrar los elementos del mantenedor
                $resultado = mysqli_query($conexion, "SELECT * FROM paises");
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id_pais']}</td>
                            <td>{$fila['nombre_pais']}</td>
                            <td>
                                <a href='editar_pais.php?id={$fila['id_pais']}' class='btn btn-primary'>Editar</a>
                                <a href='eliminar_pais.php?id={$fila['id_pais']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar este país?\");'>Eliminar</a>
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
