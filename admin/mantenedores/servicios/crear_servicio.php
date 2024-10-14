<?php
include '../conexion.php';
include '../navbar.php';

//si se envia, subir los datos al mantenedor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_servicio = $_POST['nombre_servicio'];
    $descripcion = $_POST['descripcion'];
    $precio_servicio = $_POST['precio_servicio'];
    $numero_en = $_POST['numero_en'];
    $sucursales = $_POST['sucursales'];

    $query = "INSERT INTO servicio (nombre_servicio, descripcion_servicio, telefono_encargado, precio_servicio) 
              VALUES ('$nombre_servicio', '$descripcion', '$numero_en', '$precio_servicio')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $id_servicio = mysqli_insert_id($conexion);

        // Insertar las asociaciones con las sucursales seleccionadas
        foreach ($sucursales as $id_sucursal) {
            $query_insertar = "INSERT INTO sucursal_servicio (id_servicio, id_sucursal) VALUES ($id_servicio, $id_sucursal)";
            mysqli_query($conexion, $query_insertar);
        }

        echo "<script>alert('Servicio creado con éxito'); window.location='mantenedor_servicios.php';</script>";
    } else {
        echo "Error al crear el servicio: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Crear Servicio</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <!-- formulario para crear elemento -->
        <h1 class="mb-4">Crear Servicio</h1>
        <form method="POST" action="crear_servicio.php">
            <div class="mb-3">
                <label for="nombre_servicio" class="form-label">Nombre del Servicio</label>
                <input type="text" class="form-control" name="nombre_servicio" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" required></textarea>
            </div>
            <div class="mb-3">
                <label for="telefono_encargado" class="form-label">Teléfono Encargado</label>
                <input type="number" class="form-control" name="numero_en" required>
            </div>
            <div class="mb-3">
                <label for="precio_servicio" class="form-label">Precio del Servicio</label>
                <input type="number" class="form-control" name="precio_servicio" required>
            </div>
            <div class="mb-3">
                <label for="sucursales" class="form-label">Sucursales Disponibles</label>
                <select class="form-select" name="sucursales[]" multiple required>
                    <?php
                    $sucursales = mysqli_query($conexion, "SELECT * FROM sucursal");
                    while ($sucursal = mysqli_fetch_assoc($sucursales)) {
                        echo "<option value='{$sucursal['id_sucursal']}'>{$sucursal['nombre_sucursal']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Crear Servicio</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>