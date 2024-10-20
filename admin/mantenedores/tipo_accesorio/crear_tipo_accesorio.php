<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];

    // Insertar elemento en la base de datos
    $query = "INSERT INTO tipo_accesorio (nombre_tipo_accesorio) VALUES ('$nombre')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Tipo de accesorio guardado con éxito'); window.location='mantenedor_tipo_accesorios.php';</script>";
    } else {
        echo "Error al guardar el tipo de accesorio: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Crear Tipo de Accesorio</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1>Crear Tipo de Accesorio</h1>
        <!-- formulario para crear elemento -->
        <form action="crear_tipo_accesorio.php" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
