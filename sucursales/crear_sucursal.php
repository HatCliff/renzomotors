<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar Sucursal</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Sucursal</h1>
        <!-- formulario para crear elemento -->
        <form method="POST">
            <div class="mb-3">
                <label for="nombre_sucursal" class="form-label">Nombre Sucursal</label>
                <input type="text" class="form-control" name="nombre_sucursal" required>
            </div>
            <div class="mb-3">
                <label for="encargado_sucursal" class="form-label">Encargado Sucursal</label>
                <input type="text" class="form-control" name="encargado_sucursal" required>
            </div>
            <div class="mb-3">
                <label for="direccion_sucursal" class="form-label">Dirección Sucursal</label>
                <input type="text" class="form-control" name="direccion_sucursal" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Sucursal</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
//si se envia, insertarlo en el mantendor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_sucursal = $_POST['nombre_sucursal'];
    $encargado_sucursal = $_POST['encargado_sucursal'];
    $direccion_sucursal = $_POST['direccion_sucursal'];

    $query = "INSERT INTO sucursales (nombre_sucursal, encargado_sucursal, direccion_sucursal) 
              VALUES ('$nombre_sucursal', '$encargado_sucursal', '$direccion_sucursal')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Sucursal guardada con éxito'); window.location='mantenedor_sucursales.php';</script>";
    } else {
        echo "Error al guardar la sucursal: " . mysqli_error($conexion);
    }
}
?>
