<?php
include '../conexion.php';
include '../navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];

    // insertar en la base de datos
    $query = "INSERT INTO cobertura (nombre_tipo_cobertura) VALUES ('$nombre')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Tipo de cobertura guardado con éxito'); window.location='mantenedor_tipo_coberturas.php';</script>";
    } else {
        echo "Error al guardar el tipo de cobertura: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear de Tipos de Cobertura</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="pt-5">
    <div class="container">
        <!-- formulario para crear el elemento -->
        <h2 class="mt-5">Agregar Tipo de Cobertura</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nombre">Nombre Tipo de Cobertura:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
