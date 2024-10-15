<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
//obtener los datos del elemento
if($_GET['id']){
    $id_sucursal = $_GET['id'];
    $query = "SELECT * FROM sucursal WHERE id_sucursal = $id_sucursal";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $sucursal = mysqli_fetch_assoc($resultado);
    } else {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
}   
//si se envia,actualizar los datos en el mantendor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_sucursal = $_POST['nombre_sucursal'];
    $encargado_sucursal = $_POST['encargado_sucursal'];
    $direccion_sucursal = $_POST['direccion_sucursal'];

    $query = "UPDATE sucursal 
              SET nombre_sucursal='$nombre_sucursal', encargado_sucursal='$encargado_sucursal', direccion_sucursal='$direccion_sucursal'
              WHERE id_sucursal=$id_sucursal";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Sucursal actualizada con éxito'); window.location='mantenedor_sucursales.php';</script>";
    } else {
        echo "Error al actualizar la sucursal: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Sucursal</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Editar Sucursal</h1>
        <!-- formulario para actualizar datos -->
        <form method="POST">
            <div class="mb-3">
                <label for="nombre_sucursal" class="form-label">Nombre Sucursal</label>
                <input type="text" class="form-control" name="nombre_sucursal" value="<?php echo $sucursal['nombre_sucursal']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="encargado_sucursal" class="form-label">Encargado Sucursal</label>
                <input type="text" class="form-control" name="encargado_sucursal" value="<?php echo $sucursal['encargado_sucursal']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="direccion_sucursal" class="form-label">Dirección Sucursal</label>
                <input type="text" class="form-control" name="direccion_sucursal" value="<?php echo $sucursal['direccion_sucursal']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Sucursal</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
