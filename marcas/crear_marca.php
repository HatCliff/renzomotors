<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar Marca</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Marca</h1>
        <!-- formulario para crear elemento -->
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion"></textarea>
            </div>
            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" class="form-control" name="logo" accept="image/png" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Marca</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
//si se envia, subir elemento al mantendor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    // Subir logo
    $logo = $_FILES['logo']['name'];
    $ruta_temporal = $_FILES['logo']['tmp_name'];
    $directorio_destino = "logos/" . $logo;
    move_uploaded_file($ruta_temporal, $directorio_destino);

    // Insertar en la base de datos
    $query = "INSERT INTO marcas (nombre_marca, descripcion, logo) VALUES ('$nombre', '$descripcion', '$logo')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Marca guardada con éxito'); window.location='mantenedor_marcas.php';</script>";
    } else {
        echo "Error al guardar la marca: " . mysqli_error($conexion);
    }
}
?>
