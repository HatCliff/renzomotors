<?php
include '../conexion.php';
include '../navbar.php';

//obtener los datos previos del elemento
$id_proveedor = $_GET['id'];
$query = "SELECT * FROM proveedores_seguro WHERE id_proveedor = $id_proveedor";
$resultado = mysqli_query($conexion, $query);
$proveedor = mysqli_fetch_assoc($resultado);

// si se envia actualizar en el mantendor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_proveedor = $_POST['nombre_proveedor'];

    
    $query = "UPDATE proveedores_seguro SET nombre_proveedor = '$nombre_proveedor' WHERE id_proveedor = $id_proveedor";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Proveedor actualizado con éxito'); window.location='mantenedor_proveedores.php';</script>";
    } else {
        echo "Error al actualizar el proveedor: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="pt-5">
    <div class="container">
        <!-- formulario edicion -->
        <h2 class="mt-5">Editar Proveedor</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nombre_proveedor" class="form-label">Nombre Proveedor</label>
                <input type="text" class="form-control" name="nombre_proveedor" value="<?php echo $proveedor['nombre_proveedor']; ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Actualizar Proveedor</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
