<?php
include '../conexion.php';
include '../navbar.php';

$id_rol = $_GET['id_rol'];

// Consultar los datos del elemento
$query = "SELECT * FROM rol WHERE id_rol = $id_rol";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    $rol = mysqli_fetch_assoc($resultado);
} else {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Obtener los permisos actuales asociados al elemento
$query_permisos = "SELECT id_permiso FROM rol_permiso WHERE id_rol = $id_rol";
$resultado_permisos = mysqli_query($conexion, $query_permisos);
$permisos_actuales = [];
while ($permiso = mysqli_fetch_assoc($resultado_permisos)) {
    $permisos_actuales[] = $permiso['id_permiso'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Rol</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <!-- formulario edicion -->
        <h1 class="mb-4">Editar Rol</h1>
        <form method="POST" action="editar_rol.php?id_rol=<?php echo $rol['id_rol']; ?>">
            <div class="mb-3">
                <label for="nombre_rol" class="form-label">Nombre del Rol</label>
                <input type="text" class="form-control" name="nombre_rol" value="<?php echo $rol['nombre_rol']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="permisos" class="form-label">Permisos Disponibles</label>
                <select class="form-select" name="permisos[]" multiple required>
                    <?php
                    // Consultar los permisos disponibles
                    $permisos = mysqli_query($conexion, "SELECT * FROM permiso");
                    while ($permiso = mysqli_fetch_assoc($permisos)) {
                        $selected = in_array($permiso['id_permiso'], $permisos_actuales) ? 'selected' : '';
                        echo "<option value='{$permiso['id_permiso']}' $selected>{$permiso['nombre_permiso']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Rol</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_rol = $_POST['nombre_rol'];
    $permisos = $_POST['permisos'];

    // Actualizar los datos del rol
    $query = "UPDATE rol 
              SET nombre_rol='$nombre_rol'
              WHERE id_rol=$id_rol";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        // Eliminar las asociaciones actuales de permisos
        $query_eliminar = "DELETE FROM rol_permiso WHERE id_rol = $id_rol";
        mysqli_query($conexion, $query_eliminar);

        // Insertar las nuevas asociaciones con los permisos seleccionados
        foreach ($permisos as $id_permiso) {
            $query_insertar = "INSERT INTO rol_permiso (id_rol, id_permiso) VALUES ($id_rol, $id_permiso)";
            mysqli_query($conexion, $query_insertar);
        }

        echo "<script>alert('Rol actualizado con éxito'); window.location='mantenedor_roles.php';</script>";
    } else {
        echo "Error al actualizar el rol: " . mysqli_error($conexion);
    }
}
?>
