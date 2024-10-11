<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar Seguro</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Agregar Seguro</h1>
        <!-- formulario para crear elemento -->
        <form method="POST">
            <div class="mb-3">
                <label for="nombre_seguro" class="form-label">Nombre del Seguro</label>
                <input type="text" class="form-control" name="nombre_seguro" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" required></textarea>
            </div>
            <div class="mb-3">
                <label for="id_proveedor" class="form-label">Proveedor</label>
                <select class="form-select" name="id_proveedor" required>
                    <?php
                    $proveedores = mysqli_query($conexion, "SELECT * FROM proveedores_seguro");
                    while ($proveedor = mysqli_fetch_assoc($proveedores)) {
                        echo "<option value='{$proveedor['id_proveedor']}'>{$proveedor['nombre_proveedor']}</option>";
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
                        echo "<option value='{$tipo['id_tipo_cobertura']}'>{$tipo['nombre_tipo_cobertura']}</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" name="precio" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Seguro</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
//si se envia, subir los datos al mantendor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_seguro = $_POST['nombre_seguro'];
    $descripcion = $_POST['descripcion'];
    $id_proveedor = $_POST['id_proveedor'];
    $id_tipo_cobertura = $_POST['id_tipo_cobertura'];
    $precio = $_POST['precio'];

    $query = "INSERT INTO seguros (nombre_seguro, descripcion, id_proveedor, id_tipo_cobertura, precio) 
              VALUES ('$nombre_seguro', '$descripcion', '$id_proveedor', '$id_tipo_cobertura', '$precio')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Seguro guardado con éxito'); window.location='mantenedor_seguros.php';</script>";
    } else {
        echo "Error al guardar el seguro: " . mysqli_error($conexion);
    }
}
?>
