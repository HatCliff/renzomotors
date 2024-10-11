<?php
include '../conexion.php';
include '../navbar.php';

if ($_GET['id_tipo_vehiculo']) {
    //consultar los datos del elemento a editar
    $id_tipo_vehiculo = $_GET['id_tipo_vehiculo'];
    $query = "SELECT * FROM tipo_vehiculo WHERE id_tipo_vehiculo = $id_tipo_vehiculo";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $tipo_vehiculo = mysqli_fetch_assoc($resultado);
    } else {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
}

//si se envia el formulario actualizar los datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tipo_vehiculo = $_POST['id_tipo_vehiculo'];
    $nombre_tipo_vehiculo = $_POST['nombre_tipo_vehiculo'];

    $query = "UPDATE tipo_vehiculo SET nombre_tipo_vehiculo = '$nombre_tipo_vehiculo' WHERE id_tipo_vehiculo = $id_tipo_vehiculo";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Transmisión actualizada con éxito'); window.location='mantenedor_tipo_vehiculos.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Tipo de Vehiculo</title>
</head>
<body class="pt-5">
    <!-- formulario para actualizar los datos -->
    <div class="container mt-5">
        <h1 class="mb-4">Editar Tipo de Vehiculo</h1>
        <form method="POST">
            <input type="hidden" name="id_tipo_vehiculo" value="<?php echo ($tipo_vehiculo['id_tipo_vehiculo']); ?>">
            <div class="mb-3">
                <label for="transmision" class="form-label">Tipo de Vehiculo</label>
                <input type="text" class="form-control" name="nombre_tipo_vehiculo" value="<?php echo ($tipo_vehiculo['nombre_tipo_vehiculo']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Tipo de Vehiculo</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
