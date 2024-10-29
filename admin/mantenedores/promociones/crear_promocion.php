<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar Promocion</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Promocion</h1>
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
                <label for="icono" class="form-label">Icono</label>
                <input type="file" class="form-control" name="icono" accept="image/png" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Promocion</button>
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

    // Subir icono
    $icono = $_FILES['icono']['name'];
    $ruta_temporal = $_FILES['icono']['tmp_name'];
    $directorio_destino = "icono_promo/" . $icono;
    move_uploaded_file($ruta_temporal, $directorio_destino);

    // Insertar en la base de datos
    $query = "INSERT INTO promocion_especial (nombre_promocion, descripcion_promocion, icono_promocion) VALUES ('$nombre', '$descripcion', '$icono')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Promocion guardada con éxito'); window.location='mantenedor_promociones.php';</script>";
    } else {
        echo "Error al guardar la Promocion: " . mysqli_error($conexion);
    }
}
?>
