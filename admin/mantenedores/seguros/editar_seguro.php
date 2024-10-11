<?php
include '../conexion.php';
include '../navbar.php';
//obtener los datos del elemento a editar
$id_seguro = $_GET['id'];
$query = "SELECT * FROM seguros WHERE id_seguro = $id_seguro";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    $seguro = mysqli_fetch_assoc($resultado);
} else {
    die("Error en la consulta: " . mysqli_error($conexion));
}
//si se envian nuevos datos los actualiza
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_seguro = $_POST['id_seguro'];
    $nombre_seguro = $_POST['nombre_seguro'];
    $descripcion = $_POST['descripcion'];
    $id_proveedor = $_POST['id_proveedor'];
    $id_tipo_cobertura = $_POST['id_tipo_cobertura'];

    $precio = $_POST['precio'];

    $query = "UPDATE seguros 
              SET nombre_seguro='$nombre_seguro', descripcion='$descripcion', id_proveedor='$id_proveedor', 
                  id_tipo_cobertura='$id_tipo_cobertura', precio='$precio' 
              WHERE id_seguro=$id_seguro";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Seguro actualizado con éxito'); window.location='mantenedor_seguros.php';</script>";
    } else {
        echo "Error al actualizar el seguro: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Seguro</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Editar Seguro</h1>
        <!-- formulario para actualizar los datos -->
        <form method="POST" action="editar_seguro.php?id=<?php echo $seguro['id_seguro']; ?>">
            <input type="hidden" name="id_seguro" value="<?php echo $seguro['id_seguro']; ?>">
            <div class="mb-3">
                <label for="nombre_seguro" class="form-label">Nombre del Seguro</label>
                <input type="text" class="form-control" name="nombre_seguro" value="<?php echo $seguro['nombre_seguro']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" required><?php echo $seguro['descripcion']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="id_proveedor" class="form-label">Proveedor</label>
                <select class="form-select" name="id_proveedor" required>
                    <?php
                    $proveedores = mysqli_query($conexion, "SELECT * FROM proveedores_seguro");
                    while ($proveedor = mysqli_fetch_assoc($proveedores)) {
                        $selected = ($proveedor['id_proveedor'] == $seguro['id_proveedor']) ? 'selected' : '';
                        echo "<option value='{$proveedor['id_proveedor']}' $selected>{$proveedor['nombre_proveedor']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_tipo_cobertura" class="form-label">Tipo de Cobertura</label>
                <select class="form-select" name="id_tipo_cobertura" required>
                    <?php
                    $tipos_cobertura = mysqli_query($conexion, "SELECT * FROM tipo_cobertura");
                    while ($tipo = mysqli_fetch_assoc($tipos_cobertura)) {
                        $selected = ($tipo['id_tipo_cobertura'] == $seguro['id_tipo_cobertura']) ? 'selected' : '';
                        echo "<option value='{$tipo['id_tipo_cobertura']}' $selected>{$tipo['nombre_tipo_cobertura']}</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" name="precio" value="<?php echo $seguro['precio']; ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Actualizar Seguro</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
