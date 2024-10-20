<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
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
                    $proveedores = mysqli_query($conexion, "SELECT * FROM proveedor");
                    while ($proveedor = mysqli_fetch_assoc($proveedores)) {
                        echo "<option value='{$proveedor['id_proveedor']}'>{$proveedor['nombre_proveedor']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_tipo_cobertura" class="form-label">Tipo de Cobertura</label>
                <select class="form-select" name="tipo_cobertura[]" multiple required>
                    <?php
                    $tipos_cobertura = mysqli_query($conexion, "SELECT * FROM cobertura");
                    while ($tipo = mysqli_fetch_assoc($tipos_cobertura)) {
                        echo "<option value='{$tipo['id_cobertura']}'>{$tipo['nombre_tipo_cobertura']}</option>";
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
    $id_proveedor = $_POST['id_proveedor'];
    $nombre_seguro = $_POST['nombre_seguro'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $tipo_cobertura = $_POST['tipo_cobertura'];

    $query_contar = "SELECT max(id_seguro) as cantidad FROM seguro";
    $resultado_contar = mysqli_query($conexion, $query_contar);
    $row = mysqli_fetch_assoc($resultado_contar); 
    $id_cantidad = $row['cantidad'] + 1;
    
    $query = "INSERT INTO seguro (id_seguro, id_proveedor, nombre_seguro, descripcion_seguro, precio_seguro) 
              VALUES ('$id_cantidad', '$id_proveedor', '$nombre_seguro', '$descripcion', '$precio')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        // insertar tipos de accesorio relacionados
        foreach ($tipo_cobertura as $id_tipo) {
            $query_tipo = "INSERT INTO seguro_cobertura (id_seguro, id_cobertura) VALUES ('$id_cantidad', '$id_tipo')";
            mysqli_query($conexion, $query_tipo);
        }

        echo "<script>alert('Seguro guardado con éxito'); window.location='mantenedor_seguros.php';</script>";
    } else {
        echo "Error al guardar el seguro: " . mysqli_error($conexion);
    }
}
?>