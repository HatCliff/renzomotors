<?php
include '../conexion.php';
include '../navbar.php';
//obtener los datos del elemento a editar
$id_seguro = $_GET['id'];
$query = "SELECT * FROM seguro WHERE id_seguro = $id_seguro";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    $seguro = mysqli_fetch_assoc($resultado);
} else {
    die("Error en la consulta: " . mysqli_error($conexion));
}

$query_tipos="SELECT id_cobertura FROM seguro_cobertura WHERE id_seguro = '$id_seguro'";
$resultado_tipos = mysqli_query($conexion,$query_tipos);
$tipos_seleccionados = [];
while ($fila = mysqli_fetch_assoc($resultado_tipos)) {
        $tipos_seleccionados[] = $fila['id_cobertura'];
}   

//si se envian nuevos datos los actualiza
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_proveedor = $_POST['id_proveedor'];
    $nombre_seguro = $_POST['nombre_seguro'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $tipo_cobertura = $_POST['tipo_cobertura'];

    $query = "UPDATE seguro 
              SET nombre_seguro='$nombre_seguro', descripcion_seguro='$descripcion', id_proveedor='$id_proveedor', 
                  precio_seguro='$precio' 
              WHERE id_seguro=$id_seguro";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        // eliminar tipos de cobertura relacionados 
        mysqli_query($conexion, "DELETE FROM seguro_cobertura WHERE id_seguro = '$id_seguro'");

        // insertar los nuevos tipos seleccionados
        foreach ($tipo_cobertura as $id_tipo) {
            $query_tipo = "INSERT INTO seguro_cobertura (id_seguro, id_cobertura) VALUES ('$id_seguro', '$id_tipo')";
            mysqli_query($conexion, $query_tipo);
        }
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
    <div class="container mt-5 pt-5">
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
                <textarea class="form-control" name="descripcion" required><?php echo $seguro['descripcion_seguro']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="id_proveedor" class="form-label">Proveedor</label>
                <select class="form-select" name="id_proveedor" required>
                    <?php
                    $proveedores = mysqli_query($conexion, "SELECT * FROM proveedor");
                    while ($proveedor = mysqli_fetch_assoc($proveedores)) {
                        $selected = ($proveedor['id_proveedor'] == $seguro['id_proveedor']) ? 'selected' : '';
                        echo "<option value='{$proveedor['id_proveedor']}' $selected>{$proveedor['nombre_proveedor']}</option>";
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
                        $selected_s = in_array($tipo['id_cobertura'], $tipos_seleccionados) ? 'selected' : '';
                        echo "<option value='{$tipo['id_cobertura']}' $selected_s>{$tipo['nombre_tipo_cobertura']}</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" name="precio" value="<?php echo $seguro['precio_seguro']; ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Actualizar Seguro</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
