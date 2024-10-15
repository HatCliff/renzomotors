<?php
include '../conexion.php';
include '../navbar.php';

//si se envia,subirlo al mantendor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_proveedor = $_POST['nombre_proveedor'];
    $query = "INSERT INTO proveedor (nombre_proveedor) VALUES ('$nombre_proveedor')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Proveedor guardado con éxito'); window.location='mantenedor_proveedores.php';</script>";
    } else {
        echo "Error al guardar el proveedor: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Proveedor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="pt-5">
    <!-- formulario para crear proveedor -->
    <div class="container">
        <h2 class="mt-5">Crear Proveedor</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nombre_proveedor" class="form-label">Nombre Proveedor</label>
                <input type="text" class="form-control" name="nombre_proveedor" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Proveedor</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
