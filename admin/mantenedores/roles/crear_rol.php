<?php
include '../conexion.php';
include '../navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_rol = $_POST['nombre_rol'];
    $permisos = $_POST['permisos']; 

    // insertar el nuevo elemento en el mantenedor
    $query = "INSERT INTO roles (nombre_rol) VALUES ('$nombre_rol')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $id_rol = mysqli_insert_id($conexion);

        // insertar las asociaciones del elemento con los permisos
        foreach ($permisos as $id_permiso) {
            $query_insertar = "INSERT INTO roles_permisos (id_rol, id_permiso) VALUES ($id_rol, $id_permiso)";
            mysqli_query($conexion, $query_insertar);
        }

        echo "<script>alert('Rol creado con éxito'); window.location='mantenedor_roles.php';</script>";
    } else {
        echo "Error al crear el rol: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Crear Rol</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <!-- formulario para crear elemento -->
        <h1 class="mb-4">Crear Rol</h1>
        <form method="POST" action="crear_rol.php">
            <div class="mb-3">
                <label for="nombre_rol" class="form-label">Nombre del Rol</label>
                <input type="text" class="form-control" name="nombre_rol" required>
            </div>
            <div class="mb-3">
                <label for="permisos" class="form-label">Permisos Disponibles</label>
                <select class="form-select" name="permisos[]" multiple required>
                    <?php
                    // consultar los permisos disponibles
                    $permisos = mysqli_query($conexion, "SELECT * FROM permisos");
                    while ($permiso = mysqli_fetch_assoc($permisos)) {
                        echo "<option value='{$permiso['id_permiso']}'>{$permiso['nombre_permiso']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Crear Rol</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
