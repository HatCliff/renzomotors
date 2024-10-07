<?php
include '../conexion.php';
include '../navbar.php';

// obtener el ID del tipo de cobertura a editar
$id = $_GET['id'];
$query = "SELECT * FROM tipo_cobertura WHERE id_tipo_cobertura = $id";
$resultado = mysqli_query($conexion, $query);
$tipo = mysqli_fetch_assoc($resultado);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];

    // actualizar en la base de datos
    $query = "UPDATE tipo_cobertura SET nombre_tipo_cobertura = '$nombre' WHERE id_tipo_cobertura = $id";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Tipo de cobertura actualizado con éxito'); window.location='mantenedor_tipo_coberturas.php';</script>";
    } else {
        echo "Error al actualizar el tipo de cobertura: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenedor de Tipos de Cobertura</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="pt-5">
    <div class="container">
        <!-- formulario para actualizar datos -->
        <h2 class="mt-5">Editar Tipo de Cobertura</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nombre">Nombre Tipo de Cobertura:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $tipo['nombre_tipo_cobertura']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>

        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
