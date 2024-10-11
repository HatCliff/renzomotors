<?php
include '../conexion.php';
include '../navbar.php';

//obtener los datos del elemento a editar
$id_pais = $_GET['id'];
$query = "SELECT * FROM paises WHERE id_pais = $id_pais";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    $pais = mysqli_fetch_assoc($resultado);
} else {
    die("Error en la consulta: " . mysqli_error($conexion));
}
//si se envia, actualizar los datos del elemento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_pais = $_POST['nombre_pais'];

    $query = "UPDATE paises SET nombre_pais='$nombre_pais' WHERE id_pais=$id_pais";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('País actualizado con éxito'); window.location='mantenedor_paises.php';</script>";
    } else {
        echo "Error al actualizar el país: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar País</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Editar País</h1>
        <!-- formulario para editar -->
        <form method="POST">
            <div class="mb-3">
                <label for="nombre_pais" class="form-label">Nombre del País</label>
                <input type="text" class="form-control" name="nombre_pais" value="<?php echo $pais['nombre_pais']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar País</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
