<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar Accesorio</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <!-- formulario para crear elemento -->
        <h1 class="mb-4">Agregar Accesorio</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="sku" class="form-label">SKU</label>
                <input type="text" class="form-control" name="sku" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" name="precio" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" name="stock" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="fotos" class="form-label">Fotos</label>
                <input type="file" class="form-control" name="fotos[]" multiple required>
            </div>
            <div class="mb-3">
                <label for="tipos_accesorio" class="form-label">Tipo de Accesorio</label>
                <select class="form-select" name="tipos_accesorio[]" multiple required>
                    <?php
                    $tipos = mysqli_query($conexion, "SELECT * FROM tipo_accesorio");
                    while ($tipo = mysqli_fetch_assoc($tipos)) {
                        echo "<option value='{$tipo['id_tipo_accesorio']}'>{$tipo['nombre_tipo_accesorio']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Guardar Accesorio</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
//si se envia, subir elemento al mantendor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sku = $_POST['sku'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $descripcion = $_POST['descripcion'];
    $tipos_accesorio = $_POST['tipos_accesorio'];

    $query = "INSERT INTO accesorio (sku_accesorio, nombre_accesorio, precio_accesorio, stock_accesorio, descripcion_accesorio) 
              VALUES ('$sku', '$nombre', '$precio', '$stock', '$descripcion')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        // insertar tipos de accesorio relacionados
        foreach ($tipos_accesorio as $id_tipo) {
            $query_tipo = "INSERT INTO pertenece_tipo (id_tipo_accesorio, sku_accesorio) VALUES ('$id_tipo', '$sku')";
            mysqli_query($conexion, $query_tipo);
        }

        // subir fotos
        foreach ($_FILES['fotos']['name'] as $key => $foto) {
            $ruta_temporal = $_FILES['fotos']['tmp_name'][$key];
            $directorio_destino = "fotos/" . $foto;
            if (move_uploaded_file($ruta_temporal, $directorio_destino)) {
                $query_foto = "INSERT INTO fotos_accesorio (sku_accesorio, foto_accesorio) VALUES ('$sku', '$directorio_destino')";
                mysqli_query($conexion, $query_foto);
            }
        }

        echo "<script>alert('Accesorio guardado con éxito'); window.location='mantenedor_accesorios.php';</script>";
    } else {
        echo "Error al guardar el accesorio: " . mysqli_error($conexion);
    }
}
?>
