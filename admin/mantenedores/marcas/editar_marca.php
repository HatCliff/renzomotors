<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';

//obtener los datos del elemento a editar
if ($_GET['id_marca']) {
    $id = $_GET['id_marca'];
    $query = "SELECT * FROM marca WHERE id_marca = $id";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $marca = mysqli_fetch_assoc($resultado);
    } else {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
}
//si se envia, actualizar los datos del elemento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $logo_anterior = $_POST['logo_anterior'];

    // Si se carga un nuevo logo
    if ($_FILES['logo']['name']) {
        $logo = $_FILES['logo']['name'];
        $logo_temp = $_FILES['logo']['tmp_name'];
        $logo_destino = 'logos/' . $logo;
        move_uploaded_file($logo_temp, $logo_destino);

        // Eliminar el logo anterior
        if ($logo_anterior) {
            unlink("logos/$logo_anterior");
        }
    } else {
        $logo = $logo_anterior;
    }

    $query = "UPDATE marca SET nombre_marca = '$nombre', descripcion_marca = '$descripcion', logo_marca = '$logo' WHERE id_marca = $id";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Marca actualizada con éxito'); window.location='mantenedor_marcas.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Marca</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Editar Marca</h1>
        <!-- formulario para editar -->
        <form action="editar_marca.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo ($marca['id_marca']); ?>">
            <input type="hidden" name="logo_anterior" value="<?php echo ($marca['logo_marca']); ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo ($marca['nombre_marca']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion"><?php echo ($marca['descripcion_marca']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" class="form-control" name="logo" accept="image/png">
                <p>Logo actual: <img src="logos/<?php echo ($marca['logo_marca']); ?>" width="50" alt="Logo"></p>
            </div>
            <button type="submit" class="btn btn-success">Actualizar Marca</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
