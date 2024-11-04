<?php
include './components/navbaruser.php';
include './config/conexion.php';

// Consulta de sucursales
$query_sucursales = "SELECT id_sucursal, nombre_sucursal FROM sucursal";
$resultado_sucursales = mysqli_query($conexion, $query_sucursales);

// Verificamos si se encontraron registros
if (!$resultado_sucursales) {
    die("Error en la consulta de sucursales: " . mysqli_error($conexion));
}

// Consulta de vehículos
$query_vehiculos = "SELECT v.id_vehiculo, v.nombre_modelo, v.precio_modelo, p.nombre_pais 
                    FROM vehiculo v
                    JOIN pais p ON v.id_pais = p.id_pais";
$resultado_vehiculos = mysqli_query($conexion, $query_vehiculos);

// Verificamos si se encontraron registros
if (!$resultado_vehiculos) {
    die("Error en la consulta de vehículos: " . mysqli_error($conexion));
}
?> 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RenzoMotors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="logo.png" type="image/png">
</head>
<body class="pt-5 mt-3">
<body>
    <?php
    include('admin/navbaradmin.php');
    ?>
    <div class="container mt-5 pt-5 hidden" style='display:none;'>
        <h1>Bienvenido a RenzoMotors</h1>
        <p>Tu automotora de confianza</p>
    </div>

<style>
        /* Ajustar el tamaño de las imágenes del carrusel */
        .carousel-item img {
            width: 100%;
            height: 600px; /* Altura fija para todas las imágenes */
            object-fit: cover; /* Ajusta la imagen para que cubra completamente el contenedor */
        }
    </style>



    <!-- Carrusel de fotos -->
    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Primer slide -->
            <div class="carousel-item active">
                <img src="./src/images/banner1.jpg" class="d-block w-100" alt="Ver Vehículos">
                <div class="carousel-caption d-none d-md-block ">
                    <H4>Conoce tu Proximo vehículo</H4>
                    <a href="../pages/buscador_vehiculo.php" class="btn btn-dark">Ver Vehículos</a>
                </div>
            </div>
            <!-- Segundo slide -->
            <div class="carousel-item">
                <img src="./src/images/banner2.jpg" class="d-block w-100" alt="Cotizar Seguro">
                <div class="carousel-caption d-none d-md-block">
                    <h4>Cotiza tu Seguro</h4>
                    <a href="#" class="btn btn-warning">Cotizar Ahora</a>
                </div>
            </div>
            <!-- Tercer slide -->
            <div class="carousel-item">
                <img src="./src/images/banner3.jpg" class="d-block w-100" alt="Compra Accesorios">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Compra Accesorios</h5>
                    <a href="#" class="btn btn-warning">Ver Accesorios</a>
                </div>
            </div>
        </div>
        <!-- Controles del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
<div class="container mt-5 pt-5">
    <!-- Sección Sucursales -->
    <div class="row">
        <div class="col-md-3">
            <h5>Sucursales</h5>
            <div class="list-group">
                <?php
                if ($resultado_sucursales->num_rows > 0) {
                    while($row = $resultado_sucursales->fetch_assoc()) {
                        echo '<label class="list-group-item">';
                        echo '<input class="form-check-input me-1" type="checkbox" value="">';
                        echo $row['nombre_sucursal'];
                        echo '</label>';
                    }
                } else {
                    echo "No se encontraron sucursales.";
                }
                ?>
            </div>
        </div>

        <!-- Sección Novedades de Vehículos -->
        <div class="col-md-9">
            <h5>Novedades en Renzo Motors</h5>
            <div class="row">
                <?php
                if ($resultado_vehiculos->num_rows > 0) {
                    while($vehiculo = $resultado_vehiculos->fetch_assoc()) {
                        $id_vehiculo = $vehiculo['id_vehiculo'];

                        // Consulta de fotos para el vehículo actual
                        $query_fotos = "SELECT ruta_foto FROM fotos_vehiculo WHERE id_vehiculo = $id_vehiculo";
                        $resultado_fotos = mysqli_query($conexion, $query_fotos);

                        echo '<div class="col-md-4 mb-4">';
                        echo '<div class="card h-100">'; // Añadido h-100 para altura completa de la tarjeta

                        // Carrusel de fotos
                        if (mysqli_num_rows($resultado_fotos) > 0) {
                            echo '<div id="carousel' . $id_vehiculo . '" class="carousel slide h-100" data-bs-ride="carousel">'; // h-100 para que ocupe toda la altura
                            echo '<div class="carousel-inner h-100">'; // h-100 para mantener la altura consistente

                            $active_class = 'active'; // La primera imagen será la activa
                            while ($foto = mysqli_fetch_assoc($resultado_fotos)) {
                                $ruta_foto = './admin/mantenedores/vehiculo/' . $foto['ruta_foto']; // Agregar 'vehiculos/' a la ruta
                                echo '<div class="carousel-item ' . $active_class . ' h-100">'; // h-100 para que la imagen ocupe toda la altura
                                echo "<img src='{$ruta_foto}' class='d-block w-100 h-100 object-fit-cover' alt='Foto del vehículo'>"; // h-100 para altura completa
                                echo '</div>';
                                $active_class = ''; // Las siguientes no deben ser "active"
                            }

                            echo '</div>'; // Cierra el carousel-inner

                            // Controles del carrusel
                            echo '<button class="carousel-control-prev" type="button" data-bs-target="#carousel' . $id_vehiculo . '" data-bs-slide="prev">';
                            echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                            echo '<span class="visually-hidden">Anterior</span>';
                            echo '</button>';
                            echo '<button class="carousel-control-next" type="button" data-bs-target="#carousel' . $id_vehiculo . '" data-bs-slide="next">';
                            echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                            echo '<span class="visually-hidden">Siguiente</span>';
                            echo '</button>';

                            echo '</div>'; // Cierra el carrusel
                        } else {
                            // Si no hay fotos, mostramos un placeholder
                            echo '<img src="car_placeholder.png" class="card-img-top" alt="Vehículo">';
                        }

                        // Información del vehículo
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $vehiculo['nombre_modelo'] . '</h5>';
                        echo '<p class="card-text">$' . number_format($vehiculo['precio_modelo']) . '</p>';
                        echo '<p class="card-text">' . $vehiculo['nombre_pais'] . '</p>';
                        echo '</div>';
                        echo '</div></div>';
                    }
                } else {
                    echo "No se encontraron vehículos.";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
