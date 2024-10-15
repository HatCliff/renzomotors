<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar Transmisión</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Transmisión</h1>
        <!-- formulario para subir datos -->
        <form method="POST">
            <div class="mb-3">
                <label for="transmision" class="form-label">Transmisión</label>
                <input type="text" class="form-control" name="nombre_transmision" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Transmisión</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
//insertar los datos al mantenedor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_transmision = $_POST['nombre_transmision'];

    $query = "INSERT INTO transmisiones (nombre_transmision) VALUES ('$nombre_transmision')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Transmisión guardada con éxito'); window.location='mantenedor_transmisiones.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>
