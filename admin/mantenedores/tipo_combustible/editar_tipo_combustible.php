<?php
include '../conexion.php';
include '../navbar.php';

//obtener los datos previos del elemento
if ($_GET['id_tipo_combustible']) {
    $id_tipo_combustible = $_GET['id_tipo_combustible'];
    $query = "SELECT * FROM tipo_combustible WHERE id_tipo_combustible = $id_tipo_combustible";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $tipo_vehiculo = mysqli_fetch_assoc($resultado);
    } else {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
}
//si se envia,subir los datos actualizados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tipo_combustible = $_POST['id_tipo_combustible'];
    $nombre_tipo_combustible = $_POST['nombre_tipo_combustible'];

    $query = "UPDATE tipo_combustible SET nombre_tipo_combustible = '$nombre_tipo_combustible' WHERE id_tipo_combustible = $id_tipo_combustible";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Transmisión actualizada con éxito'); window.location='mantenedor_tipo_combustibles.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Tipo de Combustible</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <!-- formulario para actualizar datos -->
        <h1 class="mb-4">Editar Tipo de Combustible</h1>
        <form method="POST">
            <input type="hidden" name="id_tipo_combustible" value="<?php echo ($tipo_vehiculo['id_tipo_combustible']); ?>">
            <div class="mb-3">
                <label for="transmision" class="form-label">Tipo de Combustible</label>
                <input type="text" class="form-control" name="nombre_tipo_combustible" value="<?php echo ($tipo_vehiculo['nombre_tipo_combustible']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Tipo de Combustible</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
