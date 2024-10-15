<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar País</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Agregar País</h1>
        <!-- formulario para crear elemento -->
        <form method="POST">
            <div class="mb-3">
                <label for="nombre_pais" class="form-label">Nombre del País</label>
                <input type="text" class="form-control" name="nombre_pais" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar País</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
//si se envia, subir elemento al mantendor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_pais = $_POST['nombre_pais'];

    $query = "INSERT INTO paises (nombre_pais) VALUES ('$nombre_pais')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('País guardado con éxito'); window.location='mantenedor_paises.php';</script>";
    } else {
        echo "Error al guardar el país: " . mysqli_error($conexion);
    }
}
?>
