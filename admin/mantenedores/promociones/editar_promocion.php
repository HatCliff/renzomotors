<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';

//obtener los datos del elemento a editar
if ($_GET['id_promocion']) {
    $id = $_GET['id_promocion'];
    $query = "SELECT * FROM promocion_especial WHERE id_promocion = $id";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $promocion = mysqli_fetch_assoc($resultado);
    } else {
        die("Error en la consulta: " . mysqli_error($conexion));
    }
}
//si se envia, actualizar los datos del elemento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $icono_anterior = $_POST['icono_anterior'];

    // Si se carga un nuevo icono
    if ($_FILES['icono']['name']) {
        $icono = $_FILES['icono']['name'];
        $icono_temp = $_FILES['icono']['tmp_name'];
        $icono_destino = 'icono_promo/' . $icono;
        move_uploaded_file($icono_temp, $icono_destino);

        // Eliminar el icono anterior
        if ($icono_anterior) {
            unlink("icono_promo/$icono_anterior");
        }
    } else {
        $icono = $icono_anterior;
    }

    $query = "UPDATE promocion_especial SET nombre_promocion = '$nombre', descripcion_promocion = '$descripcion', icono_promocion = '$icono' WHERE id_promocion = $id";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Promocion actualizada con éxito'); window.location='mantenedor_promociones.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Promocion</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Editar Promocion</h1>
        <!-- formulario para editar -->
        <form action="editar_promocion.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo ($promocion['id_promocion']); ?>">
            <input type="hidden" name="icono_anterior" value="<?php echo ($promocion['icono_promocion']); ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo ($promocion['nombre_promocion']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion"><?php echo ($promocion['descripcion_promocion']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="icono" class="form-label">Icono</label>
                <input type="file" class="form-control" name="icono" accept="image/png">
                <p>Icono actual: <img src="icono_promo/<?php echo ($promocion['icono_promocion']); ?>" width="50" alt="Icono"></p>
            </div>
            <button type="submit" class="btn btn-success">Actualizar Promocion</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
