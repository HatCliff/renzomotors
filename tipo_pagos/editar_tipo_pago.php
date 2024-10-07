<?php 
include '../conexion.php';
include '../navbar.php';

//obtener los datos previos del elemento
if ($_GET['id']) {
    $id_tipo_pago = $_GET['id'];
    $query = "SELECT * FROM tipos_pago WHERE id_tipo_pago = $id_tipo_pago";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $tipo_pago = mysqli_fetch_assoc($resultado);
    } else {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
}

//si se sube actualizar los datos del elemento
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);

    $query = "UPDATE tipos_pago SET nombre = '$nombre' WHERE id_tipo_pago = $id_tipo_pago";
    if (mysqli_query($conexion, $query)) {
        echo "<script>alert('Tipo de pago editado con éxito'); window.location='mantenedor_tipo_pagos.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
} 
?>

<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Tipo de Pago</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <!-- formulario para actualizar datos -->
        <h2>Editar Tipo de Pago</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nombre_tipo_pago" class="form-label">Nombre Tipo de Pago</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo $tipo_pago['nombre']; ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Tipo de Pago</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
