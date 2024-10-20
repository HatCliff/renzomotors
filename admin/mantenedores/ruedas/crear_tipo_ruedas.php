<?php
<<<<<<< HEAD
<<<<<<< HEAD
include '../conexion.php';
include '../navbar.php';
=======
include '../../../config/conexion.php';
include '../../navbaradmin.php';
>>>>>>> fmunozi
=======
include '../../../config/conexion.php';
include '../../navbaradmin.php';
>>>>>>> origin/macarrascoa
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar Tipo De rueda</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <!-- formulario para crear nuevo elemento -->
        <h1 class="mb-4">Agregar Tipo De rueda</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="nombre_tipo_rueda" class="form-label">Nombre Tipo de rueda</label>
                <input type="text" class="form-control" name="nombre_tipo_rueda" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Tipo de rueda</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// si se sube, agregarlo al mantenedor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_tipo_rueda = $_POST['nombre_tipo_rueda'];
    $query = "INSERT INTO tipo_rueda (nombre_tipo_rueda) 
              VALUES ('$nombre_tipo_rueda')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Tipo de rueda guardado con éxito'); window.location='mantenedor_ruedas.php';</script>";
    } else {
        echo "Error al guardar la sucursal: " . mysqli_error($conexion);
    }
}
?>
