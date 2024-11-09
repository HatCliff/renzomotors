<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';

//consultar los datos asociados al id desde el mantenedor
if (isset($_GET['id'])) {

    $id_vehiculo = $_GET['id'];
    $query = "SELECT * FROM vehiculo WHERE id_vehiculo = $id_vehiculo";
    $resultado = mysqli_query($conexion, $query);
    $vehiculo = mysqli_fetch_assoc($resultado);
}


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
    $puertas = $_POST['puertas'];
    $id_tipo_ruedas = $_POST['id_ruedas'];
    $horsepower = $_POST['horsepower'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $kilometraje = $_POST['kilometro'];
    $sucursales = $_POST['sucursales'];
    $promociones = $_POST['promociones'];
    $doc_anterior = $_POST['doc_anterior'];
    $arriendo = $_POST['arriendo'];

    if (isset($_FILES['docu']) && $_FILES['docu']['name']) {
        $documento_tecnico = $_FILES['docu']['name'];
        $ruta_temporal_doc = $_FILES['docu']['tmp_name'];
        $directorio_destino = "doc_tecnicos/" . basename($documento_tecnico);
        move_uploaded_file($ruta_temporal_doc, $directorio_destino) ;

        if ($doc_anterior) {
            unlink("doc_tecnicos/$doc_anterior");
        }
    } else {
        $documento_tecnico = $doc_anterior;
    }


    // actualizar información del vehículo
    $query = "UPDATE vehiculo 
                SET nombre_modelo = '$nombre_modelo',
                    precio_modelo = '$precio',
                    estado_vehiculo = '$estado_vehiculo',
                    descripcion_vehiculo = '$descripcion',
                    cantidad_vehiculo = '$cantidad',
                    cantidad_puertas = '$puertas',
                    caballos_fuerza = '$horsepower',
                    documento_tecnico = '$documento_tecnico',
                    kilometraje = '$kilometraje',
                    id_marca = '$id_marca',
                    id_anio = '$id_anio',
                    id_tipo_combustible = '$id_tipo_combustible',
                    id_pais = '$id_pais',
                    id_transmision = '$id_transmision',
                    id_tipo_vehiculo = '$id_tipo_vehiculo',
                    id_tipo_rueda = '$id_tipo_ruedas',
                    arriendo = $arriendo
                WHERE id_vehiculo = '$id_vehiculo';";
    $resultado = mysqli_query($conexion, $query);

    // actualizar colores asociados
    if (!empty($colores)) {
        // eliminar colores antiguos
        $query_eliminar_colores = "DELETE FROM color_vehiculo WHERE id_vehiculo = '$id_vehiculo'";
        mysqli_query($conexion, $query_eliminar_colores);

        // insertar los nuevos colores seleccionados
        foreach ($colores as $id_color) {
            $query_color = "INSERT INTO color_vehiculo (id_vehiculo, id_color) VALUES ('$id_vehiculo', '$id_color')";
            mysqli_query($conexion, $query_color);
        }
    }

    $query_eliminar_sucursales = "DELETE FROM vehiculo_sucursal WHERE id_vehiculo = $id_vehiculo";
    mysqli_query($conexion, $query_eliminar_sucursales);
    if(!empty($sucursales)){
        foreach ($sucursales as $id_sucursal) {
            $query_sucursal = "INSERT INTO vehiculo_sucursal (id_sucursal, id_vehiculo) VALUES ('$id_sucursal', '$id_vehiculo')";
            mysqli_query($conexion, $query_sucursal);
        }
    }

    $query_eliminar_promociones = "DELETE FROM promocion_vehiculo WHERE id_vehiculo = $id_vehiculo";
    mysqli_query($conexion, $query_eliminar_promociones);
    if(!empty($promociones)){
        foreach ($promociones as $id_promo) {
            $query_promo = "INSERT INTO promocion_vehiculo (id_vehiculo, id_promocion) VALUES ('$id_vehiculo','$id_promo')";
            mysqli_query($conexion, $query_promo);
        }
    }

    // subir nuevas fotos
    if (isset($_FILES['fotos'])) {
        $total_fotos = count($_FILES['fotos']['name']);
        for ($i = 0; $i < $total_fotos; $i++) {
            $foto_nombre = $_FILES['fotos']['name'][$i];
            $foto_tmp = $_FILES['fotos']['tmp_name'][$i];

            if (!empty($foto_tmp)) {
                $ruta_destino = "fotos_vehiculos/" . $foto_nombre;
                move_uploaded_file($foto_tmp, $ruta_destino);

                // insertar la ruta de la foto en la tabla fotos_vehiculos
                $query_foto = "INSERT INTO fotos_vehiculo (id_vehiculo, ruta_foto) VALUES ('$id_vehiculo', '$ruta_destino')";
                mysqli_query($conexion, $query_foto);
            }
        }
    }

    if ($resultado) {
        echo "<script>alert('Vehículo actualizado con éxito'); window.location='mantenedor_vehiculos.php';</script>";
    } else {
        echo "Error al actualizar el vehículo: " . mysqli_error($conexion);
    }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Vehículo</title>
</head>

<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Editar Vehículo</h1>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_vehiculo" value="<?php echo $vehiculo['id_vehiculo']; ?>">
            <input type="hidden" name="doc_anterior" value="<?php echo ($vehiculo['documento_tecnico']); ?>">
            <div class="mb-3">
                <label for="nombre_modelo" class="form-label">Nombre del Modelo</label>
                <input type="text" class="form-control" name="nombre_modelo"
                    value="<?php echo $vehiculo['nombre_modelo']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion"
                    required><?php echo $vehiculo['descripcion_vehiculo']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="id_marca" class="form-label">Marca</label>
                <select class="form-select" name="id_marca" required>
                    <?php
                    $marcas = mysqli_query($conexion, "SELECT * FROM marca");
                    while ($marca = mysqli_fetch_assoc($marcas)) {
                        $selected = ($marca['id_marca'] == $vehiculo['id_marca']) ? 'selected' : '';
                        echo "<option value='{$marca['id_marca']}' $selected>{$marca['nombre_marca']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="horsepower" class="form-label">Caballos de Fuerza</label>
                <input type="number" class="form-control" name="horsepower"
                    value="<?php echo $vehiculo['caballos_fuerza']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="kilometro" class="form-label">Kilometraje</label>
                <input type="number" class="form-control" name="kilometro" value="<?php echo $vehiculo['kilometraje']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="puertas" class="form-label">Número de Puertas</label>
                <select class="form-select" name="puertas" required>
                    <option value="2" <?php echo ($vehiculo['cantidad_puertas'] == 2) ? 'selected' : ''; ?>>2 Puertas
                    </option>
                    <option value="4" <?php echo ($vehiculo['cantidad_puertas'] == 4) ? 'selected' : ''; ?>>4 Puertas
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_anio" class="form-label">Año</label>
                <select class="form-select" name="id_anio" required>
                    <?php
                    $anios = mysqli_query($conexion, "SELECT * FROM anio");
                    while ($anio = mysqli_fetch_assoc($anios)) {
                        $selected = ($anio['id_anio'] == $vehiculo['id_anio']) ? 'selected' : '';
                        echo "<option value='{$anio['id_anio']}' $selected>{$anio['anio']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_tipo_vehiculo" class="form-label">Tipo de Vehículo</label>
                <select class="form-select" name="id_tipo_vehiculo" required>
                    <?php
                    $tipos = mysqli_query($conexion, "SELECT * FROM tipo_vehiculo");
                    while ($tipo = mysqli_fetch_assoc($tipos)) {
                        $selected = ($tipo['id_tipo_vehiculo'] == $vehiculo['id_tipo_vehiculo']) ? 'selected' : '';
                        echo "<option value='{$tipo['id_tipo_vehiculo']}' $selected>{$tipo['nombre_tipo_vehiculo']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_transmision" class="form-label">Transmisión</label>
                <select class="form-select" name="id_transmision" required>
                    <?php
                    $transmisiones = mysqli_query($conexion, "SELECT * FROM transmision");
                    while ($transmision = mysqli_fetch_assoc($transmisiones)) {
                        $selected = ($transmision['id_transmision'] == $vehiculo['id_transmision']) ? 'selected' : '';
                        echo "<option value='{$transmision['id_transmision']}' $selected>{$transmision['nombre_transmision']}</option>";
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
                        $selected = ($combustible['id_tipo_combustible'] == $vehiculo['id_tipo_combustible']) ? 'selected' : '';
                        echo "<option value='{$combustible['id_tipo_combustible']}' $selected>{$combustible['nombre_tipo_combustible']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="estado_vehiculo" class="form-label">Estado Vehiculo</label>
                <select class="form-select" name="estado_vehiculo"
                    required>
                    <option value="usado" <?php echo ($vehiculo['estado_vehiculo'] == 'usado') ? 'selected' : ''; ?>>Usado</option>
                    <option value="nuevo" <?php echo ($vehiculo['estado_vehiculo'] == 'nuevo') ? 'selected' : ''; ?>>Nuevo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_ruedas" class="form-label">Ruedas</label>
                <select class="form-select" name="id_ruedas" required>
                    <?php
                    $ruedas = mysqli_query($conexion, "SELECT * FROM tipo_rueda");
                    while ($rueda = mysqli_fetch_assoc($ruedas)) {
                        echo "<option value='{$rueda['id_tipo_rueda']}' $selected>{$rueda['nombre_tipo_rueda']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_pais" class="form-label">País de Origen</label>
                <select class="form-select" name="id_pais" required>
                    <?php
                    $paises = mysqli_query($conexion, "SELECT * FROM pais");
                    while ($pais = mysqli_fetch_assoc($paises)) {
                        $selected = ($pais['id_pais'] == $vehiculo['id_pais']) ? 'selected' : '';
                        echo "<option value='{$pais['id_pais']}' $selected>{$pais['nombre_pais']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" name="precio"
                    value="<?php echo $vehiculo['precio_modelo']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" name="cantidad"
                    value="<?php echo $vehiculo['cantidad_vehiculo']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="colores" class="form-label">Colores del Vehículo</label>
                <div class="form-check d-flex flex-row">
                    <div class="row">
                        <?php
                        // obtener los colores asociados al vehículo
                        $colores_vehiculo = [];
                        $resultado_colores = mysqli_query($conexion, "SELECT id_color FROM color_vehiculo WHERE id_vehiculo = $id_vehiculo");
                        while ($color_vehiculo = mysqli_fetch_assoc($resultado_colores)) {
                            $colores_vehiculo[] = $color_vehiculo['id_color'];
                        }

                        // mostrar todos los colores
                        $colores = mysqli_query($conexion, "SELECT * FROM color");
                        while ($color = mysqli_fetch_assoc($colores)) {
                            $checked = in_array($color['id_color'], $colores_vehiculo) ? 'checked' : '';
                            $color_hex = $color['codigo_color']; // Asumimos que este campo contiene el código hexadecimal del color.
                            echo "<div class=''>
                                <input class='form-check-input' type='checkbox' name='colores[]' value='{$color['id_color']}' $checked id='color_{$color['id_color']}'>
                                <label class='form-check-label' for='color_{$color['id_color']}' style='display: inline-block; width: 40px; height: 40px; background-color: {$color_hex}; border: 1px solid #000;'></label>
                                </div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="promociones" class="form-label">Promociones incluidas:</label>
                <div class="form-check d-flex flex-row">
                    <?php
                    $promociones_vehiculo = [];
                    $resultado_promociones = mysqli_query($conexion, "SELECT id_promocion FROM promocion_vehiculo WHERE id_vehiculo = $id_vehiculo");
                        while ($promo_vehiculo = mysqli_fetch_assoc($resultado_promociones)) {
                            $promociones_vehiculo[] = $promo_vehiculo['id_promocion'];
                        }

                    $promociones = mysqli_query($conexion, "SELECT * FROM promocion_especial");
                    while ($promo = mysqli_fetch_assoc($promociones)) {
                        $checked = in_array($promo['id_promocion'], $promociones_vehiculo) ? 'checked' : '';
                        echo "
                        <div class='form-check d-flex justify-content-center align-items-center'>
                                <input class='form-check-input' type='checkbox' name='promociones[]' value='{$promo['id_promocion']}' $checked id='promocion_{$promo['nombre_promocion']}''>
                                <label class='form-check-label' for='promocion_{$promo['nombre_promocion']}' style='padding: 20px;'>
                                {$promo['nombre_promocion']}
                            </label>
                        </div>
                        ";
                    }
                    ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="arriendo" class="form-label">¿Es para arriendo?</label>
                <select class="form-select" name="arriendo" aria-label="Default select example" require>
                    <option value="1" <?php echo ($vehiculo['arriendo'] == '1') ? 'selected' : ''; ?>>Si</option>
                    <option value="0" <?php echo ($vehiculo['arriendo'] == '0') ? 'selected' : ''; ?>>No</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="sucursales" class="form-label">Disponible en: </label>
                <div class="form-check d-flex flex-row">
                    <?php

                    $sucursales_vehiculos = [];
                    $resultado_sucursales = mysqli_query($conexion, "SELECT id_sucursal FROM vehiculo_sucursal WHERE id_vehiculo = $id_vehiculo");
                    while ($sucursal_vehiculo = mysqli_fetch_assoc($resultado_sucursales)) {
                        $sucursales_vehiculos[] = $sucursal_vehiculo['id_sucursal'];
                    }

                    $sucursales = mysqli_query($conexion, "SELECT * FROM sucursal");
                    while ($sucursal = mysqli_fetch_assoc($sucursales)) {
                        $checked = in_array($sucursal['id_sucursal'], $sucursales_vehiculos) ? 'checked' : '';
                        echo "
                    <div class='form-check d-flex justify-content-center align-items-center'>
                        <input class='form-check-input' type='checkbox' name='sucursales[]' value='{$sucursal['id_sucursal']}' $checked id='sucursal_{$sucursal['id_sucursal']}'>
                        <label class='form-check-label' for='sucursal_{$sucursal['id_sucursal']}' style='padding: 20px;'>
                            {$sucursal['nombre_sucursal']}
                        </label>
                    </div>
                    ";
                    }
                    ?>
                </div>
            </div>

            <!-- subir fotos -->
            <div class="mb-3">
                <label for="fotos" class="form-label">Agregar Fotos</label>
                <input type="file" class="form-control" name="fotos[]" multiple>
            </div>
            
            <!-- Mostrar las fotos actuales -->
            <div class="mb-3">
                <label class="form-label">Fotos Actuales</label>
                <div class="row">
                    <?php
                    $fotos = mysqli_query($conexion, "SELECT * FROM fotos_vehiculo WHERE id_vehiculo = $id_vehiculo");
                    while ($foto = mysqli_fetch_assoc($fotos)) {
                        echo "<div class='col-md-3'>
                        <img src='{$foto['ruta_foto']}' class='img-fluid mb-2' alt='Foto del vehículo'>
                        <a href='eliminar_foto.php?id_foto={$foto['id_foto_vehiculo']}&id_vehiculo={$id_vehiculo}&ruta_foto={$foto['ruta_foto']}' class='btn btn-danger btn-sm'>Eliminar</a>
                        </div>";
                    }
                    ?>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="docu" class="form-label">Cambiar Documento técnico del Vehículo:</label>
                <input type="file" class="form-control" name="docu">
                <a href='doc_tecnicos/<?php echo $vehiculo['documento_tecnico']; ?>' download>Ver documento actual</a>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Vehículo</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>