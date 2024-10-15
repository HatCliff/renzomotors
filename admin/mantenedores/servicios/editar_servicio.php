<?php
include '../conexion.php';
include '../navbar.php';

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
        <form method="POST" action="editar_servicio.php?id=<?php echo $servicio['id_servicio']; ?>">
            <div class="mb-3">
                <label for="nombre_servicio" class="form-label">Nombre del Servicio</label>
                <input type="text" class="form-control" name="nombre_servicio" value="<?php echo $servicio['nombre_servicio']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" required><?php echo $servicio['descripcion_servicio']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="telefono_encargado" class="form-label">Teléfono Encargado</label>
                <input type="number" class="form-control" name="numero_en" value="<?php echo $servicio['telefono_encargado']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="precio_servicio" class="form-label">Precio del Servicio</label>
                <input type="number" class="form-control" name="precio_servicio" value="<?php echo $servicio['precio_servicio']; ?>" required>
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
            <button type="submit" class="btn btn-primary">Actualizar Servicio</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
sucursal
<?php
//verifica y maneja las asociaciones al momento de actualizar los datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_servicio = $_POST['nombre_servicio'];
    $descripcion = $_POST['descripcion'];
    $precio_servicio = $_POST['precio_servicio'];
    $numero_en = $_POST['numero_en'];
    $sucursales = $_POST['sucursales'];

    $query = "UPDATE servicio 
              SET nombre_servicio='$nombre_servicio', descripcion_servicio='$descripcion', telefono_encargado = '$numero_en', precio_servicio='$precio_servicio'
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