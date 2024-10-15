<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar Tipo De Pago</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <!-- formulario para crear nuevo elemento -->
        <h1 class="mb-4">Agregar Tipo De Pago</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="nombre_tipo_pago" class="form-label">Nombre Tipo de Pago</label>
                <input type="text" class="form-control" name="nombre_tipo_pago" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Tipo de Pago</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// si se sube, agregarlo al mantenedor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_tipo_pago = $_POST['nombre_tipo_pago'];
    $query = "INSERT INTO tipo_pago (nombre_tipo_pago) 
              VALUES ('$nombre_tipo_pago')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Tipo de Pago guardado con éxito'); window.location='mantenedor_tipo_pagos.php';</script>";
    } else {
        echo "Error al guardar la sucursal: " . mysqli_error($conexion);
    }
}
?>
