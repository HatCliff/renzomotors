<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../config/conexion.php');
if (isset($_SESSION['tipo_persona'])=== 'administrador') {
    include '../admin/navbaradmin.php';
} else {
    include '../components/navbaruser.php';
}

$id_vehiculo = $_GET['id'];
$current_rating = null;
// Consultas para obtener la información del vehículo
$vehiculo_query = "SELECT v.*, m.nombre_marca, a.anio, c.nombre_tipo_combustible, p.nombre_pais, t.nombre_transmision
                   FROM vehiculo v
                   JOIN marca m ON v.id_marca = m.id_marca
                   JOIN anio a ON v.id_anio = a.id_anio
                   JOIN tipo_combustible c ON v.id_tipo_combustible = c.id_tipo_combustible
                   JOIN pais p ON v.id_pais = p.id_pais
                   JOIN transmision t ON v.id_transmision = t.id_transmision
                   WHERE v.id_vehiculo = $id_vehiculo";

$vehiculo_result = mysqli_query($conexion, $vehiculo_query);
$vehiculo = mysqli_fetch_assoc($vehiculo_result);

// Consulta para obtener las fotos del vehículo
$fotos_query = "SELECT * FROM fotos_vehiculo WHERE id_vehiculo = $id_vehiculo";
$fotos_result = mysqli_query($conexion, $fotos_query);

// Consulta para obtener los colores del vehículo
$colores_query = "SELECT c.nombre_color, c.codigo_color 
    FROM color_vehiculo cv 
    JOIN color c ON cv.id_color = c.id_color 
    WHERE cv.id_vehiculo = $id_vehiculo
";

//Consulta para obtener los tipos de carroceria
$carroceria_query = "SELECT nombre_tipo_vehiculo FROM tipo_vehiculo WHERE id_tipo_vehiculo=(SELECT id_tipo_vehiculo FROM vehiculo WHERE id_vehiculo=$id_vehiculo)";
$carroceria_result = mysqli_query($conexion, $carroceria_query);

//Consulta para obtener los tipos de ruedas
$ruedas_query = "SELECT nombre_tipo_rueda FROM tipo_rueda WHERE id_tipo_rueda=(SELECT id_tipo_rueda FROM vehiculo WHERE id_vehiculo=$id_vehiculo)";
$ruedas_result = mysqli_query($conexion, $ruedas_query);

//Consulta para obtener el documento tecnico
$doc_query = "SELECT documento_tecnico FROM vehiculo WHERE id_vehiculo = $id_vehiculo";
$doc_result = mysqli_query($conexion, $doc_query);

$colores_result = mysqli_query($conexion, $colores_query);

// Consulta para obtener las opiniones
$opiniones_query = "SELECT * FROM opinion_vehiculo WHERE id_vehiculo = $id_vehiculo";
$opiniones_result = mysqli_query($conexion, $opiniones_query);


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <title>Detalles del Vehículo</title>
</head>
<style>
    body{
        background-color: #e6e6e6;
    }
    .card-img-top {
        height: auto;
        width: 100%;
        max-height: 500px;
        object-fit: cover;
    }

    .carousel-inner img {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: cover;
    }

    .color-circle {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: inline-block;
        border: 1px solid #000;
        margin: 2px;
    }

    @media (max-width: 768px) {
        .descripcion {
            margin-top: 20px;
        }
    }

    @media (min-width: 769px) {
        .descripcion {
            margin-left: 20px;
        }
    }

    .rating i {
            font-size: 2rem;
            cursor: pointer;
        }
        .text-warning {
            color: #f39c12;
        }

    td.dato{
        background:#666666;
        color: white;
    }
    td.l{
        background:#CCCCCC; 
    }
    .table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
    }
    .rounded {
        border-radius: 10px; /* Redondeo para la tabla */
        overflow: hidden; /* Asegura que el borde se mantenga redondeado */
    }
</style>

<body class="pt-5">
    <div class="container mt-5">
        <div class="row">
            <!-- Tarjeta con carrusel, nombre, precio y país de origen -->
            <div class="col-lg-8 mb-3">
                <div class="card" style="background: #fffcf4; border-radius: 20px;">
                    <div id="carouselFotos" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $active = true;
                            while ($foto = mysqli_fetch_assoc($fotos_result)) {
                                $ruta_imagen = '../admin/mantenedores/vehiculo/' . $foto['ruta_foto'];
                                echo "<div class='carousel-item " . ($active ? 'active' : '') . "'>";
                                echo "<img src='$ruta_imagen' class='d-block w-100 card-img-top ' alt='Foto del Vehículo'>";
                                echo "</div>";
                                $active = false;
                            }
                            ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselFotos"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselFotos"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title" style="font-weight: bold;"><?php echo $vehiculo['nombre_modelo']; ?></h4>
                        <p class="card-text" style="color:#3c4043; font-weight: bold;">
                            $<?php echo number_format($vehiculo['precio_modelo'], 0, ',', '.'); ?> CLP -
                            <?php echo $vehiculo['anio']; ?>
                        </p>
                        <p class="card-text" style="color: #6D6D6D; font-weight: bold;">
                            <?php echo $vehiculo['nombre_pais']; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta para reservar el vehículo -->
            <div class="col-lg-4 d-flex align-items-center justify-content-center">
                <div class="card w-100 px-2" style="background: #CCCCCC;" >
                    <div class="card-body" >
                        <h5 class="card-title">Reservar este vehículo</h5>
                        <div>
                            <?php
                            $disponible = mysqli_query($conexion, "SELECT vs.*, su.nombre_sucursal 
                                FROM vehiculo_sucursal vs
                                JOIN sucursal su ON su.id_sucursal = vs.id_sucursal
                                WHERE vs.id_vehiculo = '$id_vehiculo'
                                ORDER BY vs.id_sucursal");
                            if (mysqli_num_rows($disponible) > 0) {
                                echo "
                                      <div class='mb-3'>
                                      <label for='id_sucursal' class='form-label'>Disponible en: </label>
                                      <select class='form-select' name='id_sucursal' required>";
                                while ($disp = mysqli_fetch_assoc($disponible)) {
                                    echo '<option value=\'' . $disp['id_sucursal'] . '\'>' . $disp['nombre_sucursal'] . '</option>';
                                }
                                echo "</select>
                                      </div>
 
                                        ";
                                while ($disp = mysqli_fetch_assoc($disponible)) {
                                    echo "<option value='{$disp['id_sucursal']}'>{$disp['nombre_sucursal']}</option>";
                                }
                            } else {
                                echo "<p class='fst-italic'>Este vehículo no está disponible en ninguna sucursal</p>";
                            }
                            ?>
                            <?php
                            if (isset($_SESSION['usuario'])) {
                                // Si hay una sesión activa, muestra el botón habilitado
                                echo '<div class="d-grid">
                                        <a href="reservar_vehiculo.php?id=' . $id_vehiculo . '" class="btn " style="text-decoration: none; background: #ffc107;">Reservar</a>
                                      </div>';
                            } else {
                                // Si no hay sesión, muestra el botón deshabilitado
                                echo '<div class="d-grid">
                                          <a href="#" class="btn disabled" aria-disabled="true" style="text-decoration: none; background: #ffc107;">Reservar</a>
                                      </div>';
                            }
                            ?>

                            <div class="text-center pt-3 d-flex justify-content-center">
                                <?php
                                $modelo_query = "SELECT precio_modelo FROM vehiculo WHERE id_vehiculo = '$id_vehiculo'";
                                $modelos = mysqli_query($conexion, $modelo_query);
                                while ($modelo = mysqli_fetch_assoc($modelos)) {
                                    $precio = $modelo['precio_modelo'] * 0.01;
                                    echo "
                                <p class='fs-6 fw-light fst-italic'> *Cuota de reserva:
                                <p class='text-primary fs-6 fw-light fst-italic'> 
                                    " . number_format($precio, 0, ',', '.') . " CLP
                                </p>
                                </p>
                            ";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información adicional del vehículo: Tabla y descripción ocupando todo el ancho -->
            <div class="row mt-4">
                <div class="col-lg-12 d-flex flex-column flex-lg-row">
                    <table class="table me-5 rounded border">
                        <tr>
                            <td class="dato">Marca</td>
                            <td class="l"><?php echo $vehiculo['nombre_marca']; ?></td>
                        </tr>
                        <tr>
                            <td class="dato">Kilometraje</td>
                            <td class="l"><?php echo $vehiculo['kilometraje']; ?></td>
                        </tr>
                        <tr>
                            <td  class="dato">Año</td>
                            <td class="l"><?php echo $vehiculo['anio']; ?></td>
                        </tr>
                        <tr>
                            <td  class="dato">Cantidad de Puertas</td>
                            <td class="l"><?php echo $vehiculo['cantidad_puertas']; ?></td>
                        </tr>
                        <tr>
                            <td  class="dato">Colores</td>
                            <td class="l">
                                <?php
                                while ($color = mysqli_fetch_assoc($colores_result)) {
                                    echo "<span class='color-circle' style='background-color: {$color['codigo_color']};' title='{$color['nombre_color']}'></span>";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td  class="dato">Estado</td>
                            <td class="l"><?php echo $vehiculo['estado_vehiculo']; ?></td>
                        </tr>
                        <tr>
                            <td  class="dato">Ruedas</td>
                            <td  class="l">
                                <?php
                                while ($ruedas = mysqli_fetch_assoc($ruedas_result)) {
                                    echo $ruedas['nombre_tipo_rueda'];
                                } ?>
                            </td>
                        </tr>
                        <tr>
                            <td  class="dato">Combustible</td>
                            <td class="l"><?php echo $vehiculo['nombre_tipo_combustible']; ?></td>
                        </tr>
                        <tr>
                            <td  class="dato">Carrocería</td>
                            <td class="l">
                                <?php
                                while ($carroceria = mysqli_fetch_assoc($carroceria_result)) {
                                    echo $carroceria['nombre_tipo_vehiculo'];
                                } ?>
                            </td>
                        </tr>

                        <tr>
                            <td  class="dato">Caballos de Fuerza</td>
                            <td class="l"><?php echo $vehiculo['caballos_fuerza']; ?></td>
                        </tr>
                        <tr>
                            <td  class="dato">Transmisión</td>
                            <td class="l"><?php echo $vehiculo['nombre_transmision']; ?></td>
                        </tr>
                    </table>

                    <!-- Descripción del vehículo -->
                    <div>
                        <div class="descripcion">
                            <h5>Descripción:</h5>
                            <p><?php echo $vehiculo['descripcion_vehiculo']; ?></p>
                        </div>
                        <div class="descripcion">
                            <h5>Obtener Documento tecnico:</h5>
                            <?php
                            $doc_tecnico = mysqli_fetch_assoc($doc_result);
                            echo "<a href='../admin/mantenedores/vehiculo/doc_tecnicos/{$doc_tecnico['documento_tecnico']}' 
                            download='{$doc_tecnico['documento_tecnico']}' 
                            class='d-flex align-items-end'>Descargar Documento</a>";
                            ?>
                        </div>
                        <div class="mt-4 ms-3">
                        <!-- Sección de calculadora -->
                        <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                <div class="modal-header d-flex justify-content-between align-items-center" style="border-bottom: none;">
                                    <h1 class="modal-title fs-5 text-center flex-grow-1" id="exampleModalToggleLabel" style="font-weight: bold; font-size: 24px;">CALCULADORA DE FINANCIAMIENTO</h1>
                                    <button type="button" class="btn-close" style="width: 20px; height: 20px; border-radius: 50%; border: 3px solid black;" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                    <div class="modal-body">
                                        <?php include("financiamiento.php"); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Botón para abrir el modal -->
                        <button class="btn" data-bs-toggle="modal" data-bs-target="#exampleModalToggle" style="background: #2E2E2E; color:white;">Financiamiento</button>                        
                        </div>

                    </div>
                </div>
            </div>
            <!-- Sección de opiniones de los usuarios -->
            <hr>
            <div class="row me-2 ms-2">
                <div class="row">
                    <div class="col-8">
                        <?php
                        // Consulta para obtener la suma de las calificaciones
                        $suma_result = mysqli_query($conexion, "SELECT SUM(calificacion) AS suma FROM opinion_vehiculo WHERE id_vehiculo = $id_vehiculo");
                        $cant_result = mysqli_query($conexion, "SELECT COUNT(calificacion) AS cantidad FROM opinion_vehiculo WHERE id_vehiculo = $id_vehiculo");

                        // Obtener los valores de la suma y la cantidad
                        $suma = mysqli_fetch_assoc($suma_result)['suma'] ?? 0;
                        $cant = mysqli_fetch_assoc($cant_result)['cantidad'] ?? 0;

                        // Calcular el promedio
                        $promedio = $cant > 0 ? $suma / $cant : 0; // Evitar división por cero   
                        // Mostrar el promedio con dos decimales
                        echo "<h4>Opiniones de los usuarios: " . number_format($promedio, 1) . "  <i class='bi bi-star-fill text-warning'></i></h4>";
                        ?>
                    </div>
                </div>
                <div class="row overflow-auto mt-3" style="max-height: 400px;">
                    <?php
                    while ($row = mysqli_fetch_assoc($opiniones_result)) {
                        echo "<div class='card ms-2 me-2 mb-2' style='width: 18rem;'>";
                            echo "<div class='card-body'>";
                                echo "<div class=' d-flex justify-content-center' style='font-size: 2rem;'>";
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= (int)$row['calificacion']) {
                                        echo "<i class='bi bi-star-fill text-warning'></i>"; 
                                    } else {
                                        echo "<i class='bi bi-star text-secondary'></i>"; 
                                    }
                                }
                                echo "</div>";
                                echo "<h5 class='card-title mt-3'>{$row['titulo_resenia']}</h5>";
                                echo "<p class='card-text mb-4'>{$row['resenia']}</p>";
                                if ((int)$row['anonima'] === 1) {
                                    echo "<h6 class='card-subtitle mb-2 text-body-secondary'>Anónimo</h6>";
                                } else {
                                    $re = mysqli_query($conexion, "SELECT nombre FROM usuario_registrado WHERE rut = '{$row['rut']}'");
                                    if ($re && mysqli_num_rows($re) > 0) {
                                        $nombreRow = mysqli_fetch_assoc($re);
                                        $nombre = htmlspecialchars($nombreRow['nombre'], ENT_QUOTES, 'UTF-8');
                                        echo "<h6 class='card-subtitle mb-2 text-body-secondary'>$nombre</h6>";
                                    } else {
                                        echo "<h6 class='card-subtitle mb-2 text-body-secondary'>Usuario desconocido</h6>";
                                    }
                                }
                                $fechaFormatoInvertido = date("d-m-y", strtotime($row['fecha_resenia']));
                                echo "<h6 class='card-subtitle mb-2 text-body-secondary'>$fechaFormatoInvertido</h6>";
                            echo "</div>";
                        echo "</div>"; 
                    }
                    ?>
                </div>
                <div class="row mb-3 mt-2">
                    <div class="col">
                        <?php
                        include 'opinion.php';
                        ?>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
            
        </div>
    </div>
        <?php
            include("../components/footer.php")
        ?>
    
    </body>
</html>