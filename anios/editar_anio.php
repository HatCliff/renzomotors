<?php
include '../conexion.php';
include '../navbar.php';

//obtener los datos del elemento a editar
if ($_GET['id_anio']) {
    $id_anio = $_GET['id_anio'];
    $query = "SELECT * FROM anios WHERE id_anio = $id_anio";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $anio = mysqli_fetch_assoc($resultado);
    } else {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
}
//si se envia, actualizar los datos del elemento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_anio = $_POST['id_anio'];
    $anio_valor = $_POST['anio'];

    $query = "UPDATE anios SET anio = '$anio_valor' WHERE id_anio = $id_anio";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Año actualizado con éxito'); window.location='mantenedor_anios.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Año</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Editar Año</h1>
        <!-- formulario para editar -->
        <form method="POST">
            <input type="hidden" name="id_anio" value="<?php echo ($anio['id_anio']); ?>">
            <div class="mb-3">
                <label for="anio" class="form-label">Año</label>
                <input type="number" class="form-control" name="anio" value="<?php echo ($anio['anio']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Año</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
