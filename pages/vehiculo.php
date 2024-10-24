<?php
include('../config/conexion.php');

include('../components/navbaruser.php');

$id_fina = $_GET['id'];

$vehiculo = mysqli_query($conexion,"SELECT v.*, nombre_pais, nombre_marca, anio 
                                                  FROM vehiculo v
                                                  JOIN pais ON pais.id_pais = v.id_pais
                                                  JOIN anio ON anio.id_anio = v.id_anio
                                                  JOIN marca ON marca.id_marca = v.id_marca
                                                  WHERE id_vehiculo = $id_fina");
$consulta = mysqli_query($conexion, "SELECT * FROM opinion_vehiculo WHERE id_vehiculo = $id_fina");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Vehiculos</title>

    <!-- Para dar style al pagina y modal -->
    <style>
        body {
            font-family: "Roboto", sans-serif;
        }

        .modal-dialog {
            max-width: 750px;
            margin: 20px auto;
        }

        label {
            font-size: 15px
        }
    </style>

</head>

<body class="pt-5">
    <div class="container mt-5">
        <div class="row">
            <div class="col mb-4">
                <h1>Informacion del vehículo</h1>
                <!-- Modal de financiamiento -->
                <div class="modal fade" id="exampleModalToggle" aria-hidden="true"
                    aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between align-items-center"
                                style="border-bottom: none;">
                                <h1 class="modal-title fs-5 text-center flex-grow-1" id="exampleModalToggleLabel"
                                    style="font-weight: bold; font-size: 24px;">CALCULADORA DE FINANCIAMIENTO</h1>
                                <button type="button" class="btn-close "
                                    style="width: 20px; height: 20px; border-radius: 50%; border: 3px solid black;"
                                    data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                include("financiamiento.php");
                                ?>
                            </div>
                        </div>
                    </div>
                </div>


                <button class="btn btn-info" data-bs-target="#exampleModalToggle"
                    data-bs-toggle="modal">Financiamiento</button>
            </div>
            <hr>
        </div>

        <div class="row px-3">
            <div class="col-8">
                <?php
                while ($fila = mysqli_fetch_assoc($vehiculo)) {

                    // Coloca cada vehiculo en tarjetas
                    echo "<div class='col-12 d-flex align-items-stretch '>";
                    echo "<div class='card'  style=' background: #fffcf4; border-radius: 20px;overflow: hidden;'>";
                    // saca una foto asociada al vehiculo
                    $id_vehiculo = $fila['id_vehiculo'];
                    $fotos_vehiculo = mysqli_query($conexion, "SELECT ruta_foto FROM fotos_vehiculo WHERE id_vehiculo = $id_vehiculo");

                    if ($foto = mysqli_fetch_assoc($fotos_vehiculo)) {
                        $ruta_imagen = '../admin/mantenedores/vehiculo/' . $foto['ruta_foto'];
                        echo "<div style='background-image: url($ruta_imagen); background-size: cover; background-position: center; height: 250px; border-radius: 20px 20px 0 0;'></div>";
                        echo "
                                            <div class='card-img-overlay d-flex justify-content-start align-items-start p-3 text-center'>
                                                <h6 class='card-title border p-2 text-capitalize' style='width: 90px; border-radius: 80px; border: 3px solid black; font-size:1rem; background: white;'>{$fila['estado_vehiculo']}</h6>
                                            </div>";

                        $colores_vehiculo = mysqli_query($conexion, "SELECT c.codigo_color 
                                            FROM color_vehiculo vc
                                            JOIN color c ON vc.id_color = c.id_color
                                            WHERE vc.id_vehiculo = $id_vehiculo");
                        $color = mysqli_fetch_assoc($colores_vehiculo);
                        $codigo_color = htmlspecialchars($color['codigo_color']);

                        echo "
                                            <div class='card-img-overlay d-flex align-items-end flex-column justify-content-center text-center mt-4 mb-5'>
                                                <h6 class='card-title border p-2 d-flex align-items-end flex-column ' style='width: 80px; height: 30px; border-radius: 80px; border: 3px solid black; font-size:1rem; background: $codigo_color;'></h6>
                                            </div>";
                    }

                    echo "<div class='card-body m-3 flex-grow-1' >";
                    $precio_formateado = number_format($fila['precio_modelo'], 0, ',', '.');
                    echo "<h4 class='card-title' style='font-weight: bold'>{$fila['nombre_modelo']}</h4>
                                            <p class='card-text' style='color:426B1F; font-weight: bold; '>\$ " . $precio_formateado . " CLP  -  {$fila['anio']}</p>";
                    echo "<p class='card-text' style='color: #6D6D6D; font-weight: bold;'>{$fila['nombre_pais']}</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</a>";
                    echo "</div>";
                }
                ?>
            </div>
            <div class="col-4 bg-success bg-gradient rounded">

            </div>
        </div>

        <div class="row mt-5 ms-5">
            <div class="row">
                <div class="col-8">
                    <?php
                    // Consulta para obtener la suma de las calificaciones
                    $suma_result = mysqli_query($conexion, "SELECT SUM(calificacion) AS suma FROM opinion_vehiculo WHERE id_vehiculo = $id_fina");
                    $cant_result = mysqli_query($conexion, "SELECT COUNT(calificacion) AS cantidad FROM opinion_vehiculo WHERE id_vehiculo = $id_fina");

                    // Obtener los valores de la suma y la cantidad
                    $suma = mysqli_fetch_assoc($suma_result)['suma'] ?? 0;
                    $cant = mysqli_fetch_assoc($cant_result)['cantidad'] ?? 0;

                    // Calcular el promedio
                    $promedio = $cant > 0 ? $suma / $cant : 0; // Evitar división por cero   
                    
                    // Mostrar el promedio con dos decimales
                    echo "<p>Opinión de los usuarios: " . number_format($promedio, 1) . "★</p>"
                        ?>
                </div>
                <div class="col-4">
                    <div class="modal fade" id="exampleModal" aria-hidden="true"
                        aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-between align-items-center"
                                    style="border-bottom: none;">
                                    <h1 class="modal-title fs-5 text-center flex-grow-1" id="exampleModalToggleLabel"
                                        style="font-weight: bold; font-size: 24px;"></h1>
                                    <button type="button" class="btn-close "
                                        style="width: 20px; height: 20px; border-radius: 50%; border: 3px solid black;"
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    include("opinion.php");
                                    ?>
                                </div>

                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success" data-bs-target="#exampleModal" data-bs-toggle="modal">Escribe la
                        tuya -></button>
                </div>
            </div>
            <div class="row overflow-auto" style="max-height: 400px;">
                <?php
                while ($row = mysqli_fetch_assoc($consulta)) {

                    echo "<div class='card me-2 mb-2' style='width: 18rem;'>";
                    echo " <div class='card-body'>";
                    echo " <div class='rating d-flex start-content-center mb-3' style='font-size: 1.5rem;'>";
                    for ($i = 0; $i < 5; $i++) {
                        if ($i < $row['calificacion']) {
                            echo '<i class="bi bi-star-fill text-warning"></i>';
                        } else {
                            echo '<i class="bi bi-star"></i>';
                        }
                    }
                    echo "</div>";
                    echo " <h5 class='card-title'>{$row['titulo_resenia']}</h5>";
                    echo " <p class='card-text mb-4'>{$row['resenia']}</p>";
                    if ($row['anonima'] == 1) {
                        echo "<h6 class='card-subtitle mb-2 text-body-secondary'>anonimo</h6>";
                    } else {
                        $re = mysqli_query($conexion, "SELECT nombre FROM usuario_registrado where rut = '{$row['rut']}'");
                        $nombreRow = mysqli_fetch_assoc($re);
                        $nombre = $nombreRow['nombre'];
                        echo " <h6 class='card-subtitle mb-2 text-body-secondary'>$nombre</h6>";
                    }
                    $fechaFormatoInvertido = date("d-m-Y", strtotime($row['fecha_resenia']));
                    echo " <h6 class='card-subtitle mb-2 text-body-secondary'>$fechaFormatoInvertido</h6>";

                    echo " </div>";
                    echo " </div>";
                }
                ?>
            </div>


        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

</html>