<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Agregar Vehículo</title>
</head>
<body class="pt-5">
    <div class="container mt-5">
        <!-- mostrar campos para rellenar y crear vehiculo -->
        <h1 class="mb-4">Agregar Vehículo</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre_modelo" class="form-label">Nombre del Modelo</label>
                <input type="text" class="form-control" name="nombre_modelo" required>
            </div>
            <div class="mb-3">
                <label for="id_marca" class="form-label">Marca</label>
                <select class="form-select" name="id_marca" required>
                    <?php
                    $marcas = mysqli_query($conexion, "SELECT * FROM marcas");
                    while ($marca = mysqli_fetch_assoc($marcas)) {
                        echo "<option value='{$marca['id_marca']}'>{$marca['nombre_marca']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_anio" class="form-label">Año</label>
                <select class="form-select" name="id_anio" required>
                    <?php
                    $anios = mysqli_query($conexion, "SELECT * FROM anios");
                    while ($anio = mysqli_fetch_assoc($anios)) {
                        echo "<option value='{$anio['id_anio']}'>{$anio['anio']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" name="precio" required>
            </div>
            <div class="mb-3">
                <label for="id_tipo_vehiculo" class="form-label">Tipo de Vehículo</label>
                <select class="form-select" name="id_tipo_vehiculo" required>
                    <?php
                    $tipos = mysqli_query($conexion, "SELECT * FROM tipo_vehiculo");
                    while ($tipo = mysqli_fetch_assoc($tipos)) {
                        echo "<option value='{$tipo['id_tipo_vehiculo']}'>{$tipo['nombre_tipo_vehiculo']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_transmision" class="form-label">Transmisión</label>
                <select class="form-select" name="id_transmision" required>
                    <?php
                    $transmisiones = mysqli_query($conexion, "SELECT * FROM transmisiones");
                    while ($transmision = mysqli_fetch_assoc($transmisiones)) {
                        echo "<option value='{$transmision['id_transmision']}'>{$transmision['nombre_transmision']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_tipo_combustible" class="form-label">Tipo de Combustible</label>
                <select class="form-select" name="id_tipo_combustible" required>
                    <?php
                    $combustibles = mysqli_query($conexion, "SELECT * FROM tipo_combustible");
                    while ($combustible = mysqli_fetch_assoc($combustibles)) {
                        echo "<option value='{$combustible['id_tipo_combustible']}'>{$combustible['nombre_tipo_combustible']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="estado_vehiculo" class="form-label">Estado Vehiculo</label>
                <select class="form-select" name="estado_vehiculo" required>
                    <option value="Usado">Usado</option>
                    <option value="Nuevo">Nuevo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_pais" class="form-label">País de Origen</label>
                <select class="form-select" name="id_pais" required>
                    <?php
                    $paises = mysqli_query($conexion, "SELECT * FROM paises");
                    while ($pais = mysqli_fetch_assoc($paises)) {
                        echo "<option value='{$pais['id_pais']}'>{$pais['nombre_pais']}</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="colores" class="form-label">Colores del Vehículo</label>
                <div class="form-check">
                    <?php
                    $colores = mysqli_query($conexion, "SELECT * FROM colores");
                    while ($color = mysqli_fetch_assoc($colores)) {
                        echo "
                            <div class='form-check'>
                                <input class='form-check-input' type='checkbox' name='colores[]' value='{$color['id_color']}' id='color_{$color['id_color']}'>
                                <label class='form-check-label' for='color_{$color['id_color']}' style='background-color: {$color['codigo_color']}; padding: 20px; color: #fff;'></label>
                            </div>
                        ";
                    }
                    ?>
                </div>
            </div>
            <!-- subir varias fotos -->
            <div class="mb-3">
                <label for="fotos" class="form-label">Subir Fotos del Vehículo</label>
                <input type="file" class="form-control" name="fotos[]" multiple required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Vehículo</button>
        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_modelo = $_POST['nombre_modelo'];
    $id_marca = $_POST['id_marca'];
    $id_anio = $_POST['id_anio'];
    $precio = $_POST['precio'];
    $id_tipo_vehiculo = $_POST['id_tipo_vehiculo'];
    $id_transmision = $_POST['id_transmision'];
    $id_tipo_combustible = $_POST['id_tipo_combustible'];
    $estado_vehiculo = $_POST['estado_vehiculo'];
    $id_pais = $_POST['id_pais'];
    $colores = $_POST['colores'];

    // insertar el vehículo
    $query = "INSERT INTO vehiculos (nombre_modelo, id_marca, id_anio, precio, id_tipo_vehiculo, id_transmision, id_tipo_combustible, estado, id_pais) 
              VALUES ('$nombre_modelo', '$id_marca', '$id_anio', '$precio', '$id_tipo_vehiculo', '$id_transmision', '$id_tipo_combustible','$estado_vehiculo', '$id_pais')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        // obtener el ID del vehículo 
        $id_vehiculo = mysqli_insert_id($conexion);

        // insertar los colores seleccionados
        if (!empty($colores)) {
            foreach ($colores as $id_color) {
                $query_color = "INSERT INTO vehiculo_colores (id_vehiculo, id_color) VALUES ('$id_vehiculo', '$id_color')";
                mysqli_query($conexion, $query_color);
            }
        }

        // subir las fotos
        foreach ($_FILES['fotos']['tmp_name'] as $key => $tmp_name) {
            $foto = $_FILES['fotos']['name'][$key];
            $ruta_temporal = $_FILES['fotos']['tmp_name'][$key];
            $directorio_destino = "fotos_vehiculos/" . $foto;

            // subir fotos a la carpeta
            if (move_uploaded_file($ruta_temporal, $directorio_destino)) {
                // insertar la ruta de la foto en la base de datos
                $query_foto = "INSERT INTO fotos_vehiculos (id_vehiculo, ruta_foto) VALUES ('$id_vehiculo', '$directorio_destino')";
                mysqli_query($conexion, $query_foto);
            }
        }

        echo "<script>alert('Vehículo y datos guardados con éxito'); window.location='mantenedor_vehiculos.php';</script>";
    } else {
        echo "Error al guardar el vehículo: " . mysqli_error($conexion);
    }
}
?>
