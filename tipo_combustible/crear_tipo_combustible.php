<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar Tipo de Combustible</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <!-- formulario para crear nuevo elemento -->
        <h1 class="mb-4">Agregar Tipo de Combustible</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="transmision" class="form-label"> Tipo de Combustible</label>
                <input type="text" class="form-control" name="nombre_tipo_combustible" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Tipo de Combustible</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
//si se envia, subir los datos al mantenedor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_tipo_combustible = $_POST['nombre_tipo_combustible'];

    $query = "INSERT INTO tipo_combustible (nombre_tipo_combustible) VALUES ('$nombre_tipo_combustible')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Tipo de combustible guardado con éxito'); window.location='mantenedor_tipo_combustibles.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>
