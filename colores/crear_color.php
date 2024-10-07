<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar Color</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Color</h1>
        <!-- formulario para crear elemento -->
        <form method="POST">
            <div class="mb-3">
                <label for="nombre_color" class="form-label">Nombre del Color</label>
                <input type="text" class="form-control" name="nombre_color" required>
            </div>
            <div class="mb-3">
                <label for="codigo_color" class="form-label">Código del Color (Hexadecimal)</label>
                <input type="color" class="form-control" name="codigo_color" required>
            </div>
            <button type="submit" class="btn btn-success">Agregar Color</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php
//si se envia, subir elemento al mantendor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_color = $_POST['nombre_color'];
    $codigo_color = $_POST['codigo_color'];

    $query = "INSERT INTO colores (nombre_color, codigo_color) VALUES ('$nombre_color', '$codigo_color')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Color agregado con éxito'); window.location='mantenedor_colores.php';</script>";
    } else {
        echo "Error al agregar el color: " . mysqli_error($conexion);
    }
}
?>