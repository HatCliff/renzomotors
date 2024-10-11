<?php
include '../conexion.php';
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mantenedor de Vehículos</title>
</head>

<body class="pt-5">
    <div class="container mt-5">
        <h1 class="mb-4">Vehículos</h1>
        <a href="crear_vehiculo.php" class="btn btn-success mb-3">Agregar Vehículo</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Año</th>
                    <th>Precio</th>
                    <th>Tipo de Vehículo</th>
                    <th>Transmisión</th>
                    <th>Combustible</th>
                    <th>Estado del Vehículo</th>
                    <th>País de Origen</th>
                    <th>Fotos</th> 
                    <th>Colores</th> 
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consulta para obtener todos los datos del mantendeor 
                $resultado = mysqli_query($conexion, "SELECT v.*, m.nombre_marca, a.anio, t.nombre_tipo_vehiculo, tr.nombre_transmision, c.nombre_tipo_combustible, p.nombre_pais
                                                      FROM vehiculos v
                                                      JOIN marcas m ON v.id_marca = m.id_marca
                                                      JOIN anios a ON v.id_anio = a.id_anio
                                                      JOIN tipo_vehiculo t ON v.id_tipo_vehiculo = t.id_tipo_vehiculo
                                                      JOIN transmisiones tr ON v.id_transmision = tr.id_transmision
                                                      JOIN tipo_combustible c ON v.id_tipo_combustible = c.id_tipo_combustible
                                                      JOIN paises p ON v.id_pais = p.id_pais");

                while ($fila = mysqli_fetch_assoc($resultado)) {
                    // Mostrar los datos del mantenedor
                    echo "<tr>
                            <td>{$fila['id_vehiculo']}</td>
                            <td>{$fila['nombre_modelo']}</td>
                            <td>{$fila['nombre_marca']}</td>
                            <td>{$fila['anio']}</td>
                            <td>{$fila['precio']}</td>
                            <td>{$fila['nombre_tipo_vehiculo']}</td>
                            <td>{$fila['nombre_transmision']}</td>
                            <td>{$fila['nombre_tipo_combustible']}</td>
                            <td>{$fila['estado']}</td>
                            <td>{$fila['nombre_pais']}</td>
                            <td>";

                    // Mostrar todas las fotos asociadas al mantenedor
                    $id_vehiculo = $fila['id_vehiculo'];
                    $fotos_resultado = mysqli_query($conexion, "SELECT ruta_foto FROM fotos_vehiculos WHERE id_vehiculo = $id_vehiculo");

                    while ($foto = mysqli_fetch_assoc($fotos_resultado)) {
                        echo "<img src='{$foto['ruta_foto']}' alt='Foto vehículo' width='100' height='100' class='img-thumbnail me-2'>";
                    }

                    echo "</td>";

                    // Obtener todos los colores asociados al mantenedor
                    echo "<td>";
                    $colores_resultado = mysqli_query($conexion, "SELECT c.nombre_color, c.codigo_color 
                                                                  FROM vehiculo_colores vc
                                                                  JOIN colores c ON vc.id_color = c.id_color
                                                                  WHERE vc.id_vehiculo = $id_vehiculo");

                    while ($color = mysqli_fetch_assoc($colores_resultado)) {
                        echo "<span style='background-color: {$color['codigo_color']}; padding: 0 10px; margin-right: 5px; border: 1px solid #000;'></span> ";
                    }

                    echo "</td>";

                    //editar o eliminar algun elemento del mantenedor
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
