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
<<<<<<< HEAD
<<<<<<< HEAD
    <div class="container-fluid px-5 mt-5">
        <h1 class="mb-4">Vehículos</h1>
        <a href="crear_vehiculo.php" class="btn btn-success mb-3">Agregar Vehículo</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Modelo</th>
                    <th>Descripción Vehículo</th>
                    <th>Marca</th>
                    <th>Año</th>
                    <th>Caballos de Fuerza</th>
                    <th>Cantidad de Puertas</th>
                    <th>Estado del Vehículo</th>
                    <th>Tipo de Vehículo</th>
                    <th>Transmisión</th>
                    <th>Combustible</th>
                    <th>País de Origen</th>
                    <th>Ruedas</th> 
                    <th>Precio</th>
                    <th>Cantidad de Ejemplares</th>
                    <th>Fotos</th> 
                    <th>Colores</th> 
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta para obtener todos los datos del mantendeor 
                $resultado = mysqli_query($conexion, "SELECT v.*, m.nombre_marca, a.anio, t.nombre_tipo_vehiculo, tr.nombre_transmision, c.nombre_tipo_combustible, p.nombre_pais, r.nombre_tipo_rueda
                                                      FROM vehiculo v
                                                      JOIN marca m ON v.id_marca = m.id_marca
                                                      JOIN anio a ON v.id_anio = a.id_anio
                                                      JOIN tipo_vehiculo t ON v.id_tipo_vehiculo = t.id_tipo_vehiculo
                                                      JOIN transmision tr ON v.id_transmision = tr.id_transmision
                                                      JOIN tipo_combustible c ON v.id_tipo_combustible = c.id_tipo_combustible
                                                      JOIN pais p ON v.id_pais = p.id_pais
                                                      JOIN tipo_rueda r ON r.id_tipo_rueda = v. id_tipo_rueda
                                                      ORDER BY v.id_vehiculo ASC");

                while ($fila = mysqli_fetch_assoc($resultado)) {
                    // Mostrar los datos del mantenedor
                    echo "<tr>
                            <td>{$fila['id_vehiculo']}</td>
                            <td>{$fila['nombre_modelo']}</td>
                            <td>{$fila['descripcion_vehiculo']}</td>
                            <td>{$fila['nombre_marca']}</td>
                            <td>{$fila['anio']}</td>
                            <td>{$fila['caballos_fuerza']}</td>
                            <td>{$fila['cantidad_puertas']}</td>
                            <td>{$fila['estado_vehiculo']}</td>
                            <td>{$fila['nombre_tipo_vehiculo']}</td>
                            <td>{$fila['nombre_transmision']}</td>
                            <td>{$fila['nombre_tipo_combustible']}</td>
                            <td>{$fila['nombre_pais']}</td>
                            <td>{$fila['nombre_tipo_rueda']}</td>
                            <td>{$fila['precio_modelo']}</td> 
                            <td>{$fila['cantidad_vehiculo']}</td> 
                            <td>";

                    // Mostrar todas las fotos asociadas al mantenedor
                    $id_vehiculo = $fila['id_vehiculo'];
                    $fotos_resultado = mysqli_query($conexion, "SELECT ruta_foto FROM fotos_vehiculo WHERE id_vehiculo = $id_vehiculo");
=======
    <div class="container mt-5">
=======
    <div class="container-fluid px-5 mt-5">
>>>>>>> origin/macarrascoa
        <h1 class="mb-4 text-center">Vehículos</h1>
        <a href="crear_vehiculo.php" class="btn btn-success mb-3">Agregar Vehículo</a>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Modelo</th>
                        <th style="width: 250px;">Descripción Vehículo</th>
                        <th>Marca</th>
                        <th>Año</th>
                        <th>Caballos de Fuerza</th>
                        <th>Cantidad de Puertas</th>
                        <th>Estado del Vehículo</th>
                        <th>Tipo de Vehículo</th>
                        <th>Transmisión</th>
                        <th>Combustible</th>
                        <th>País de Origen</th>
                        <th>Ruedas</th>
                        <th>Precio</th>
                        <th>Cantidad de Ejemplares</th>
                        <th>Fotos</th>
                        <th>Colores</th>
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
                                <td>{$fila['id_vehiculo']}</td>
                                <td>{$fila['nombre_modelo']}</td>
                                <td class='text-truncate' style='max-width: 200px;'>{$fila['descripcion_vehiculo']}</td>
                                <td>{$fila['nombre_marca']}</td>
                                <td>{$fila['anio']}</td>
                                <td>{$fila['caballos_fuerza']}</td>
                                <td>{$fila['cantidad_puertas']}</td>
                                <td>{$fila['estado_vehiculo']}</td>
                                <td>{$fila['nombre_tipo_vehiculo']}</td>
                                <td>{$fila['nombre_transmision']}</td>
                                <td>{$fila['nombre_tipo_combustible']}</td>
                                <td>{$fila['nombre_pais']}</td>
                                <td>{$fila['nombre_tipo_rueda']}</td>
                                <td>{$fila['precio_modelo']}</td>
                                <td>{$fila['cantidad_vehiculo']}</td>
                                <td>
                                    <div id='carousel-{$fila['id_vehiculo']}' class='carousel slide' data-bs-ride='carousel' style='width: 200px; height: 150px;'>
                                        <div class='carousel-inner'>";
<<<<<<< HEAD
>>>>>>> fmunozi
=======
>>>>>>> origin/macarrascoa

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
                                </div>
                            </td>";

<<<<<<< HEAD
<<<<<<< HEAD
                    // Obtener todos los colores asociados al mantenedor
                    echo "<td>";
                    $colores_resultado = mysqli_query($conexion, "SELECT c.nombre_color, c.codigo_color 
                                                                  FROM color_vehiculo cv
                                                                  JOIN color c ON cv.id_color = c.id_color
                                                                  WHERE cv.id_vehiculo = $id_vehiculo");
=======
=======
>>>>>>> origin/macarrascoa
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
<<<<<<< HEAD
>>>>>>> fmunozi
=======
>>>>>>> origin/macarrascoa

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
