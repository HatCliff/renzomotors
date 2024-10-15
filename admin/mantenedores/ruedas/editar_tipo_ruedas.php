<?php 
include '../../../config/conexion.php';
include '../../navbaradmin.php';

//obtener los datos previos del elemento
if ($_GET['id']) {
    $id_tipo_rueda = $_GET['id'];
    $query = "SELECT * FROM tipo_rueda WHERE id_tipo_rueda = $id_tipo_rueda";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $tipo_rueda = mysqli_fetch_assoc($resultado);
    } else {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
}

//si se sube actualizar los datos del elemento
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);

    $query = "UPDATE tipo_rueda SET nombre_tipo_rueda = '$nombre' WHERE id_tipo_rueda = $id_tipo_rueda";
    if (mysqli_query($conexion, $query)) {
        echo "<script>alert('Tipo de rueda editado con éxito'); window.location='mantenedor_ruedas.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
} 
?>

<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Tipo de rueda</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <!-- formulario para actualizar datos -->
        <h2>Editar Tipo de rueda</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nombre_tipo_rueda" class="form-label">Nombre Tipo de rueda</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo $tipo_rueda['nombre_tipo_rueda']; ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Tipo de rueda</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
