<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';

//obtener los datos del elemento a editar
$id_servicio = $_GET['id'];
$query = "SELECT * FROM servicio WHERE id_servicio = $id_servicio";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    $servicio = mysqli_fetch_assoc($resultado);
} else {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// obtener las sucursales actuales del servicio
$query_sucursales = "SELECT id_sucursal FROM sucursal_servicio WHERE id_servicio = $id_servicio";
$resultado_sucursales = mysqli_query($conexion, $query_sucursales);
$sucursales_actuales = [];
while ($sucursal = mysqli_fetch_assoc($resultado_sucursales)) {
    $sucursales_actuales[] = $sucursal['id_sucursal'];
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Servicio</title>
</head>

<body class="pt-5">
    <!-- formulario para actualizar datos -->
    <div class="container mt-5">
        <h1 class="mb-4">Editar Servicio</h1>
        <form method="POST" action="editar_servicio.php?id=<?php echo $servicio['id_servicio']; ?>"
            enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre_servicio" class="form-label">Nombre del Servicio</label>
                <input type="text" class="form-control" name="nombre_servicio"
                    value="<?php echo $servicio['nombre_servicio']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion"
                    required><?php echo $servicio['descripcion_servicio']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="telefono_encargado" class="form-label">Teléfono Encargado</label>
                <input type="number" class="form-control" name="numero_en"
                    value="<?php echo $servicio['telefono_encargado']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="precio_servicio" class="form-label">Precio del Servicio</label>
                <input type="number" class="form-control" name="precio_servicio"
                    value="<?php echo $servicio['precio_servicio']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="sucursales" class="form-label">Sucursales Disponibles</label>
                <select class="form-select" name="sucursales[]" multiple required>
                    <?php
                    $sucursales = mysqli_query($conexion, "SELECT * FROM sucursal");
                    while ($sucursal = mysqli_fetch_assoc($sucursales)) {
                        $selected = in_array($sucursal['id_sucursal'], $sucursales_actuales) ? 'selected' : '';
                        echo "<option value='{$sucursal['id_sucursal']}' $selected>{$sucursal['nombre_sucursal']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Imagen Referencial Actual:</label><br>
                <img src="<?php echo $servicio['imagen_servicio']; ?>" alt="" class="img-thumbnail"
                    style="max-width: 250px">
            </div>
            <div class="mb-3">
                <label for="foto_referencia" class="form-label">Imagen Referencial Nueva</label>
                <input type="file" class="form-control" name="foto_referencia">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Servicio</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
sucursal
<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';

// Obtener los datos del elemento a editar
$id_servicio = $_GET['id'];
$query = "SELECT * FROM servicio WHERE id_servicio = $id_servicio";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    $servicio = mysqli_fetch_assoc($resultado);
} else {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Obtener las sucursales actuales del servicio
$query_sucursales = "SELECT id_sucursal FROM sucursal_servicio WHERE id_servicio = $id_servicio";
$resultado_sucursales = mysqli_query($conexion, $query_sucursales);
$sucursales_actuales = [];
while ($sucursal = mysqli_fetch_assoc($resultado_sucursales)) {
    $sucursales_actuales[] = $sucursal['id_sucursal'];
}

// Verifica si se está enviando el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_servicio = $_POST['nombre_servicio'];
    $descripcion = $_POST['descripcion'];
    $precio_servicio = $_POST['precio_servicio'];
    $numero_en = $_POST['numero_en'];
    $sucursales = $_POST['sucursales'];

    $imagen_actual = $servicio['imagen_servicio'];

    // Si se sube una nueva imagen se elimina la anterior y se incorpora la nueva
    if (isset($_FILES['foto_referencia']) && $_FILES['foto_referencia']['error'] == UPLOAD_ERR_OK) {
        // Eliminar la imagen antigua si existe
        if (!empty($imagen_actual) && file_exists($imagen_actual)) {
            unlink($imagen_actual);
        }

        $directorio_destino = "imagen_servicio/";
        $foto_referencia = $_FILES['foto_referencia']['name'];
        $ruta_temporal = $_FILES['foto_referencia']['tmp_name'];
        $ruta_final = $directorio_destino . $foto_referencia;

        if (move_uploaded_file($ruta_temporal, $ruta_final)) {
            $imagen_actual = $ruta_final;
        }
    }

    $query = "UPDATE servicio 
              SET nombre_servicio='$nombre_servicio', descripcion_servicio='$descripcion', telefono_encargado='$numero_en',
                  imagen_servicio='$imagen_actual', precio_servicio='$precio_servicio'
              WHERE id_servicio=$id_servicio";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        // Eliminar las asociaciones actuales
        $query_eliminar = "DELETE FROM sucursal_servicio WHERE id_servicio = $id_servicio";
        mysqli_query($conexion, $query_eliminar);

        // Insertar las nuevas asociaciones con las sucursales seleccionadas
        foreach ($sucursales as $id_sucursal) {
            $query_insertar = "INSERT INTO sucursal_servicio (id_servicio, id_sucursal) VALUES ($id_servicio, $id_sucursal)";
            mysqli_query($conexion, $query_insertar);
        }

        echo "<script>alert('Servicio actualizado con éxito'); window.location='mantenedor_servicios.php';</script>";
    } else {
        echo "Error al actualizar el servicio: " . mysqli_error($conexion);
    }
}
?>