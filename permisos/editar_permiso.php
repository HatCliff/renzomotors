<?php
include '../conexion.php';
include '../navbar.php';

//obtener los datos del elemento a editar
$id_permiso = $_GET['id_permiso'];
$query = "SELECT * FROM permisos WHERE id_permiso = $id_permiso";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    $permiso = mysqli_fetch_assoc($resultado);
} else {
    die("Error en la consulta: " . mysqli_error($conexion));
}
//si se envia,actualizar los datos del elemento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_permiso = $_POST['nombre_permiso'];

    $query = "UPDATE permisos 
              SET nombre_permiso='$nombre_permiso'
              WHERE id_permiso = $id_permiso";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Permiso actualizado con éxito'); window.location='mantenedor_permisos.php';</script>";
    } else {
        echo "Error al actualizar el permiso: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Permiso</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Editar Permiso</h1>
        <!-- formulario para editar datos -->
        <form method="POST">
            <div class="mb-3">
                <label for="nombre_permiso" class="form-label">Nombre Permiso</label>
                <input type="text" class="form-control" name="nombre_permiso" value="<?php echo $permiso['nombre_permiso']; ?>" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Actualizar Permiso</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
