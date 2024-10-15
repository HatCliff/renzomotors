<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Financiamientos</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Financiamientos</h1>
        <a href="crear_financiamiento.php" class="btn btn-success mb-3">Agregar Financiamiento</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tasa de Interés</th>
                    <th>Plazo Máximo</th>
                    <th>Requisitos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //obtener y mostrar los elementos del mantenedor
                $resultado = mysqli_query($conexion, "SELECT * FROM financiamiento");
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                            <td>{$fila['id_financiamiento']}</td>
                            <td>{$fila['nombre']}</td>
                            <td>{$fila['tasa_interes']}</td>
                            <td>{$fila['plazo_maximo']}</td>
                            <td>{$fila['requisitos']}</td>
                            <td>
                                <a href='editar_financiamiento.php?id={$fila['id_financiamiento']}' class='btn btn-primary'>Editar</a>
                                <a href='eliminar_financiamiento.php?id={$fila['id_financiamiento']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar este financiamiento?\");'>Eliminar</a>
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
