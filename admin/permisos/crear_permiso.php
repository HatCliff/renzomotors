<?php
include '../conexion.php';
include '../navbar.php';
//si se envia,insertar elemento en el mantenedor
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_permiso = $_POST['nombre_permiso'];
    
    $query = "INSERT INTO permisos (nombre_permiso) VALUES ('$nombre_permiso')";
    $resultado=mysqli_query($conexion, $query);
    
    if ($resultado) {
        
        echo "<script>alert('Permiso creado con éxito'); window.location='mantenedor_permisos.php';</script>";
    } else {
        echo "Error al crear el Permiso: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Crear Permiso</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <!-- formulario para crear elemento -->
        <h1 class="mb-4">Crear Nuevo Permiso</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="nombre_permiso" class="form-label">Nombre del Permiso</label>
                <input type="text" class="form-control" id="nombre_permiso" name="nombre_permiso" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
