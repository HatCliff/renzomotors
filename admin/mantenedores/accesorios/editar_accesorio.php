<?php
include '../conexion.php';
include '../navbar.php';

//obtener los datos del elemento a editar
$sku=$_GET['sku'];
$query="SELECT * FROM accesorios WHERE sku=$sku";      
$resultado_accesorio = mysqli_query($conexion, $query);
$accesorio = mysqli_fetch_assoc($resultado_accesorio);

// obtener fotos del accesorio
$query_fotos="SELECT * FROM fotos_accesorio WHERE sku_accesorio = '$sku'";
$resultado_fotos = mysqli_query($conexion,$query_fotos);
            
// obtener tipos del accesorio
$query_tipos="SELECT id_tipo_accesorio FROM accesorio_tipo WHERE sku_accesorio = '$sku'";
$resultado_tipos = mysqli_query($conexion,$query_tipos);
$tipos_seleccionados = [];
while ($fila = mysqli_fetch_assoc($resultado_tipos)) {
        $tipos_seleccionados[] = $fila['id_tipo_accesorio'];
}        
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Accesorio</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Editar Accesorio</h1>
        <!-- formulario para editar -->
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo $accesorio['nombre']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" name="precio" value="<?php echo $accesorio['precio']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" name="stock" value="<?php echo $accesorio['stock']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" rows="3" required><?php echo $accesorio['descripcion']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="fotos" class="form-label">Fotos Existentes</label><br>
                <!-- eliminar foto individual -->
                <?php while ($foto = mysqli_fetch_assoc($resultado_fotos)) { 
                    echo "<div class='col-md-3'>
                                <img src='{$foto['foto']}' class='img-fluid mb-2' alt='Foto del accesorio'>
                                <a href='eliminar_foto.php?id_foto={$foto['id_foto']}&sku_accesorio={$sku}&ruta_foto={$foto['foto']}' class='btn btn-danger btn-sm'>Eliminar</a>
                            </div>";

                }
                ?>
            </div>
            <div class="mb-3">
                <label for="fotos" class="form-label">Agregar Nuevas Fotos</label>
                <input type="file" class="form-control" name="fotos[]" multiple>
            </div>
            <div class="mb-3">
                <label for="tipos_accesorio" class="form-label">Tipo de Accesorio</label>
                <select class="form-select" name="tipos_accesorio[]" multiple required>
                    <?php
                    $tipos = mysqli_query($conexion, "SELECT * FROM tipos_accesorios");
                    while ($tipo = mysqli_fetch_assoc($tipos)) {
                        $selected = in_array($tipo['id_tipo_accesorio'], $tipos_seleccionados) ? 'selected' : '';
                        echo "<option value='{$tipo['id_tipo_accesorio']}' $selected>{$tipo['nombre_tipo_accesorio']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
    // si se envia, actualizar datos del elemetno
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $descripcion = $_POST['descripcion'];
    $tipos_accesorio = $_POST['tipos_accesorio'];


    $query = "UPDATE accesorios SET nombre = '$nombre', precio = '$precio', stock = '$stock', descripcion = '$descripcion' WHERE sku = '$sku'";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        // eliminar tipos de accesorio relacionados 
        mysqli_query($conexion, "DELETE FROM accesorio_tipo WHERE sku_accesorio = '$sku'");

        // insertar los nuevos tipos seleccionados
        foreach ($tipos_accesorio as $id_tipo) {
            $query_tipo = "INSERT INTO accesorio_tipo (sku_accesorio, id_tipo_accesorio) VALUES ('$sku', '$id_tipo')";
            mysqli_query($conexion, $query_tipo);
        }

        

        // subir nuevas fotos
        if (!empty($_FILES['fotos']['name'][0])) {
            foreach ($_FILES['fotos']['name'] as $key => $foto) {
                $ruta_temporal = $_FILES['fotos']['tmp_name'][$key];
                $directorio_destino = "fotos/" . $foto;
                if (move_uploaded_file($ruta_temporal, $directorio_destino)) {
                    $query_foto = "INSERT INTO fotos_accesorio (sku_accesorio, foto) VALUES ('$sku', '$directorio_destino')";
                    mysqli_query($conexion, $query_foto);
                }
            }
        }

        echo "<script>alert('Accesorio actualizado con éxito'); window.location='mantenedor_accesorios.php';</script>";
    } else {
        echo "Error al actualizar el accesorio: " . mysqli_error($conexion);
    }
}
?>
