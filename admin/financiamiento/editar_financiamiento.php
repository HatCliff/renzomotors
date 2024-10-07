<?php
include '../conexion.php';
include '../navbar.php';


//obtener los datos del elemento a editar
$id_financiamiento = $_GET['id'];
$query = "SELECT * FROM financiamiento WHERE id_financiamiento = $id_financiamiento";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    $financiamiento = mysqli_fetch_assoc($resultado);
} else {
    die("Error en la consulta: " . mysqli_error($conexion));
}

//si se envia, actualizar los datos del elemento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $tasa_interes = $_POST['tasa_interes'];
    $plazo_maximo = $_POST['plazo_maximo'];
    $requisitos = $_POST['requisitos'];

    $query = "UPDATE financiamiento 
              SET nombre='$nombre', tasa_interes=$tasa_interes, plazo_maximo='$plazo_maximo', requisitos='$requisitos' 
              WHERE id_financiamiento=$id_financiamiento";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "<script>alert('Financiamiento actualizado con éxito'); window.location='mantenedor_financiamientos.php';</script>";
    } else {
        echo "Error al actualizar el financiamiento: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Financiamiento</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Editar Financiamiento</h1>
        <!-- formulario para editar -->
        <form method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?php echo $financiamiento['nombre']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tasa_interes" class="form-label">Tasa de Interés (%)</label>
                <input type="number" step="0.01" class="form-control" name="tasa_interes" value="<?php echo $financiamiento['tasa_interes']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="plazo_maximo" class="form-label">Plazo Máximo</label>
                <input type="text" class="form-control" name="plazo_maximo" value="<?php echo $financiamiento['plazo_maximo']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="requisitos" class="form-label">Requisitos</label>
                <textarea class="form-control" name="requisitos"><?php echo $financiamiento['requisitos']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Financiamiento</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
