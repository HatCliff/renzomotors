<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar Tipo de Vehiculo</title>
</head>
<body class="pt-5">
    <!-- formulario para crear un nuevo elemento -->
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Tipo de Vehiculo</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="transmision" class="form-label"> Tipo de Vehiculo</label>
                <input type="text" class="form-control" name="nombre_tipo_vehiculo" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Tipo de Vehiculo</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
//si se sube un nuevo elemento agregarlo al mantenedor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_tipo_vehiculo = $_POST['nombre_tipo_vehiculo'];

    $query = "INSERT INTO tipo_vehiculo (nombre_tipo_vehiculo) VALUES ('$nombre_tipo_vehiculo')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Tipo de Vehiculo guardado con éxito'); window.location='mantenedor_tipo_vehiculos.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>
