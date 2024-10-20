<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar Año</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Año</h1>
        <!-- formulario para crear elemento -->
        <form method="POST">
            <div class="mb-3">
                <label for="anio" class="form-label">Año</label>
                <input type="number" class="form-control" name="anio" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Año</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
//si se envia, subir elemento al mantendor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $anio = $_POST['anio'];

    $query = "INSERT INTO anio (anio) VALUES ('$anio')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Año guardado con éxito'); window.location='mantenedor_anios.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>
