<?php
include '../conexion.php';
include '../navbar.php';


//obtener los datos previos del elemento
if ($_GET['id_tipo_accesorio']) {
    $id_tipo_accesorio = $_GET['id_tipo_accesorio'];
    $query = "SELECT * FROM tipos_accesorios WHERE id_tipo_accesorio = $id_tipo_accesorio";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $tipo = mysqli_fetch_assoc($resultado);
    } else {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tipo_accesorio = $_POST['id_tipo_accesorio'];
    $nombre = $_POST['nombre'];

    // actualizar datos en la base de datos
    $query = "UPDATE tipos_accesorios SET nombre_tipo_accesorio='$nombre' WHERE id_tipo_accesorio='$id_tipo_accesorio'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Tipo de accesorio actualizado con éxito'); window.location='mantenedor_tipo_accesorios.php';</script>";
    } else {
        echo "Error al actualizar el tipo de accesorio: " . mysqli_error($conexion);
    }
} 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Tipo de Accesorio</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1>Editar Tipo de Accesorio</h1>
        <!-- formulario actualizar datos -->
        <form action="editar_tipo_accesorio.php" method="post">
            <input type="hidden" name="id_tipo_accesorio" value="<?php echo $tipo['id_tipo_accesorio']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $tipo['nombre_tipo_accesorio']; ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Actualizar</button>

        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
