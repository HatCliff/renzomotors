<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar Financiamiento</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Financiamiento</h1>
        <!-- formulario para crear elemento -->
        <form method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="tasa_interes" class="form-label">Tasa de Interés (%)</label>
                <input type="number" step="0.01" class="form-control" name="tasa_interes" required>
            </div>
            <div class="mb-3">
                <label for="plazo_maximo" class="form-label">Plazo Máximo</label>
                <input type="text" class="form-control" name="plazo_maximo" required>
            </div>
            <div class="mb-3">
                <label for="requisitos" class="form-label">Requisitos</label>
                <textarea class="form-control" name="requisitos"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Guardar Financiamiento</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
//si se envia, subir elemento al mantendor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $tasa_interes = $_POST['tasa_interes'];
    $plazo_maximo = $_POST['plazo_maximo'];
    $requisitos = $_POST['requisitos'];

    $query = "INSERT INTO financiamiento (nombre, tasa_interes, plazo_maximo, requisitos) 
              VALUES ('$nombre', $tasa_interes, '$plazo_maximo', '$requisitos')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Financiamiento guardado con éxito'); window.location='mantenedor_financiamientos.php';</script>";
    } else {
        echo "Error al guardar el financiamiento";
    }
}
?>
