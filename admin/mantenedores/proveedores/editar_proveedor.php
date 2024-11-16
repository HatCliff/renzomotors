<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';

//obtener los datos previos del elemento
$id_proveedor = $_GET['id'];
$query = "SELECT * FROM proveedor WHERE id_proveedor = $id_proveedor";
$resultado = mysqli_query($conexion, $query);
$proveedor = mysqli_fetch_assoc($resultado);

// si se envia actualizar en el mantendor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_proveedor = $_POST['nombre_proveedor'];
    $imagen_proveedor_actual = $proveedor['imagen_proveedor'];
    $nueva_imagen = $imagen_proveedor_actual; // Mantener la imagen existente por defecto

    // Procesar la nueva imagen si se ha subido
    if (isset($_FILES['imagen_proveedor']) && $_FILES['imagen_proveedor']['error'] == 0) {
        $foto = $_FILES['imagen_proveedor']['name'];
        $ruta_temporal = $_FILES['imagen_proveedor']['tmp_name'];
        $directorio_destino = "fotos_proveedor/" . $foto;

        if (move_uploaded_file($ruta_temporal, $directorio_destino)) {
            $nueva_imagen = $directorio_destino;

            // Eliminar la imagen anterior si existía y no es la imagen por defecto
            if (file_exists($imagen_proveedor_actual) && $imagen_proveedor_actual !== "fotos_proveedor/default.png") {
                unlink($imagen_proveedor_actual);
            }
        } else {
            echo "<script>alert('Error al subir la nueva imagen.');</script>";
        }
    }
    
    $query = "UPDATE proveedor SET nombre_proveedor = '$nombre_proveedor', imagen_proveedor = '$nueva_imagen' WHERE id_proveedor = $id_proveedor";
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
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre_proveedor" class="form-label">Nombre Proveedor</label>
                <input type="text" class="form-control" name="nombre_proveedor" value="<?php echo $proveedor['nombre_proveedor']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="imagen_proveedor" class="form-label">Logo Proveedor</label>
                <input type="file" class="form-control" name="imagen_proveedor">
                <img clas="rounded mt-2 border" src="<?php echo $proveedor['imagen_proveedor']; ?>" alt="Logo actual" width="100">
            </div>
            <button type="submit" class="btn btn-success">Actualizar Proveedor</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
