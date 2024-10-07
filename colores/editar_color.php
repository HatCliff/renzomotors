<?php
include '../conexion.php';
include '../navbar.php';

//obtener los datos del elemento a editar
$id_color = $_GET['id_color'];
$query="SELECT * FROM colores WHERE id_color = $id_color";
$resultado = mysqli_query($conexion,$query);
if ($resultado) {
    $color = mysqli_fetch_assoc($resultado);
} else {
    die("Error en la consulta: " . mysqli_error($conexion));
}

//si se envia, actualizar los datos del elemento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_color = $_POST['nombre_color'];
    $codigo_color = $_POST['codigo_color'];

    $query = "UPDATE colores SET nombre_color = '$nombre_color', codigo_color = '$codigo_color' WHERE id_color = $id_color";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Color actualizado con éxito'); window.location='mantenedor_colores.php';</script>";
    } else {
        echo "Error al actualizar el color: " . mysqli_error($conexion);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Color</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Editar Color</h1>
        <!-- formulario para editar -->
        <form method="POST">
            <div class="mb-3">
                <label for="nombre_color" class="form-label">Nombre del Color</label>
                <input type="text" class="form-control" name="nombre_color" value="<?php echo $color['nombre_color']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="codigo_color" class="form-label">Código del Color (Hexadecimal)</label>
                <input type="color" class="form-control" name="codigo_color" value="<?php echo $color['codigo_color']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Color</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
