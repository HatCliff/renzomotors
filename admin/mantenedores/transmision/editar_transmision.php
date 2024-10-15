<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';

//consultar los datos asociados al id desde el mantenedor
if ($_GET['id_transmision']) {
    $id_transmision = $_GET['id_transmision'];
    $query = "SELECT * FROM transmisiones WHERE id_transmision = $id_transmision";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $transmision = mysqli_fetch_assoc($resultado);
    } else {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
}

//si se envian los datos actualizar el mantenedor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_transmision = $_POST['id_transmision'];
    $transmision_valor = $_POST['transmision'];

    $query = "UPDATE transmisiones SET nombre_transmision = '$transmision_valor' WHERE id_transmision = $id_transmision";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Transmisión actualizada con éxito'); window.location='mantenedor_transmisiones.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Transmisión</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Editar Transmisión</h1>
        <form method="POST">
            <input type="hidden" name="id_transmision" value="<?php echo ($transmision['id_transmision']); ?>">
            <div class="mb-3">
                <label for="transmision" class="form-label">Transmisión</label>
                <input type="text" class="form-control" name="transmision" value="<?php echo ($transmision['nombre_transmision']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Transmisión</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
