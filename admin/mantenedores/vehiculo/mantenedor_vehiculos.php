<?php
include '../../../config/conexion.php';
include '../../navbaradmin.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Vehículos</title>
</head>

<body class="pt-5">

    <div class="container-fluid px-5 mt-5">

        <h1 class="mb-4 text-center">Vehículos</h1>
        <a href="crear_vehiculo.php" class="btn btn-success mb-3">Agregar Vehículo</a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 300px;">Modelo</th>
                        <th>Disponibilidad</th>
                        <th style="width: 300px;">Datos varios</th>
                        <th>Media</th>
                        <th>Colores</th>
                        <th>Promos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $resultado = mysqli_query($conexion, "SELECT v.*, m.nombre_marca, a.anio, t.nombre_tipo_vehiculo, tr.nombre_transmision, c.nombre_tipo_combustible, p.nombre_pais, r.nombre_tipo_rueda
                                                          FROM vehiculo v
                                                          JOIN marca m ON v.id_marca = m.id_marca
                                                          JOIN anio a ON v.id_anio = a.id_anio
                                                          JOIN tipo_vehiculo t ON v.id_tipo_vehiculo = t.id_tipo_vehiculo
                                                          JOIN transmision tr ON v.id_transmision = tr.id_transmision
                                                          JOIN tipo_combustible c ON v.id_tipo_combustible = c.id_tipo_combustible
                                                          JOIN pais p ON v.id_pais = p.id_pais
                                                          JOIN tipo_rueda r ON r.id_tipo_rueda = v.id_tipo_rueda
                                                          ORDER BY v.id_vehiculo ASC");
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>
                                <td>
                                    <div class='fw-bold'>
                                    ({$fila['nombre_marca']}) - {$fila['nombre_modelo']}
                                    </div>
                                    <div>
                                        {$fila['nombre_tipo_vehiculo']} {$fila['estado_vehiculo']} año: {$fila['anio']}
                                    </div>
                                    <div class='text-primary fst-italic'>
                                        {$fila['nombre_pais']}
                                    </div>
                                    <div class='text-truncate mt-2 fst-italic' style='max-width: 300px;'>Desc: {$fila['descripcion_vehiculo']}>
                                    </div>
                                    <div class = 'mt-2'>
                                        Valor: $" . number_format($fila['precio_modelo'], 0, ',', '.') . " CLP  ({$fila['cantidad_vehiculo']} Un.)
                                    </div>
                                </td>";

                        echo "<td>";
                        $sucursales_resultado = mysqli_query($conexion, "SELECT s.nombre_sucursal
                                                                                    FROM vehiculo_sucursal vs
                                                                                    JOIN sucursal s ON s.id_sucursal = vs.id_sucursal
                                                                                    WHERE vs.id_vehiculo = $fila[id_vehiculo]");
                        $nombres = [];
                        while ($sucursal = mysqli_fetch_assoc($sucursales_resultado)) {
                            $nombres[] = $sucursal['nombre_sucursal'];
                        }
                        echo implode(", ", $nombres);
                        

                        echo "</td>
                                </td>

                                <td>
                                    <table class='table table-sm mb-0'>
                                        <tbody>
                                            <tr><td>HP:</td><td>{$fila['caballos_fuerza']}</td></tr>
                                            <tr><td>Puertas:</td><td>{$fila['cantidad_puertas']}</td></tr>
                                            <tr><td>Transmisión:</td><td>{$fila['nombre_transmision']}</td></tr>
                                            <tr><td>Combustible:</td><td>{$fila['nombre_tipo_combustible']}</td></tr>
                                            <tr><td>Rueda:</td><td>{$fila['nombre_tipo_rueda']}</td></tr>
                                            <tr><td>Km:</td><td>{$fila['kilometraje']}</td></tr>
                                        </tbody>
                                    </table>
                                </td>

                                <td>
                                    <div id='carousel-{$fila['id_vehiculo']}' class='carousel slide d-flex align-items-center' data-bs-ride='carousel' style='width: 200px; height: 150px;'>
                                        <div class='carousel-inner'>";
                        $id_vehiculo = $fila['id_vehiculo'];
                        $fotos_resultado = mysqli_query($conexion, "SELECT ruta_foto FROM fotos_vehiculo WHERE id_vehiculo = $id_vehiculo");
                        $active_class = "active";
                        while ($foto = mysqli_fetch_assoc($fotos_resultado)) {
                            echo "<div class='carousel-item $active_class'>
                                                        <img src='{$foto['ruta_foto']}' alt='Foto vehículo' class='d-block w-100 img-fluid'>
                                                        </div>";
                            $active_class = "";
                        }
                        echo "        </div>
                                            <button class='carousel-control-prev' type='button' data-bs-target='#carousel-{$fila['id_vehiculo']}' data-bs-slide='prev'>
                                                <span class='carousel-control-prev-icon'></span>
                                                <span class='visually-hidden'>Anterior</span>
                                            </button>
                                            <button class='carousel-control-next' type='button' data-bs-target='#carousel-{$fila['id_vehiculo']}' data-bs-slide='next'>
                                                <span class='carousel-control-next-icon'></span>
                                                <span class='visually-hidden'>Siguiente</span>
                                            </button>
                                    </div>";
                        $docs_resultado = mysqli_query($conexion, "SELECT documento_tecnico FROM vehiculo WHERE id_vehiculo = $id_vehiculo");
                        while ($docs = mysqli_fetch_assoc($docs_resultado)) {
                            $nombre_archivo = basename($docs['documento_tecnico']);
                            if(!is_null($nombre_archivo) && $nombre_archivo !== '') {
                            echo "
                                <div class='text-center'>
                                    <a href='doc_tecnicos/{$nombre_archivo}' download='{$nombre_archivo}' class=''>Descargar Documento</a>
                                </div>
                            ";
                            }
                        }                      

                        echo "<td>";
                        $colores_resultado = mysqli_query($conexion, "SELECT c.nombre_color, c.codigo_color 
                                                                                    FROM color_vehiculo cv
                                                                                    JOIN color c ON cv.id_color = c.id_color
                                                                                    WHERE cv.id_vehiculo = $id_vehiculo");
                        while ($color = mysqli_fetch_assoc($colores_resultado)) {
                            echo "<span style='background-color: {$color['codigo_color']}; width: 20px; height: 20px; display: inline-block; border-radius: 50%; margin: 2px; border: 1px solid #000;' 
                                            title='{$color['nombre_color']}'></span>";
                        }
                        echo "</td>";

                        echo "<td>";
                        $promociones_resultado = mysqli_query($conexion, "SELECT p.nombre_promocion, p.icono_promocion
                                                                                    FROM promocion_vehiculo pv
                                                                                    JOIN promocion_especial p ON p.id_promocion = pv.id_promocion
                                                                                    WHERE pv.id_vehiculo = $id_vehiculo");
                        while ($promo = mysqli_fetch_assoc($promociones_resultado)) {
                            $ruta_icono = "../promociones/icono_promo/" . $promo['icono_promocion'];
                            echo "<img src='$ruta_icono' alt='{$promo['nombre_promocion']}' style='width: 30px; height: 30px; margin: 2px;' title='{$promo['nombre_promocion']}' />";
                        }
                        echo "</td>";
                        echo "<td>
                                            <a href='editar_vehiculo.php?id={$fila['id_vehiculo']}' class='btn btn-primary'>Editar</a>
                                            <a href='eliminar_vehiculo.php?id={$fila['id_vehiculo']}' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de eliminar este vehículo?\");'>Eliminar</a>
                                        </td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>