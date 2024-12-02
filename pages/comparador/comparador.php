<?php
session_start();
include('../../config/conexion.php'); 
// Variables para almacenar los datos seleccionados
$vehiculo1 = isset($_SESSION['vehiculo1']) ? $_SESSION['vehiculo1'] : null;
$vehiculo2 = isset($_SESSION['vehiculo2']) ? $_SESSION['vehiculo2'] : null;
$vehiculo3 = isset($_SESSION['vehiculo3']) ? $_SESSION['vehiculo3'] : null;

if (isset($_POST['submitVehiculo1'])) {
    $idVehiculo1 = $_POST['vehiculo1'];
    $vehiculo1 = getVehiculoInfo($conexion, $idVehiculo1);
    $_SESSION['vehiculo1'] = $vehiculo1;
}

if (isset($_POST['submitVehiculo2'])) {
    $idVehiculo2 = $_POST['vehiculo2'];
    $vehiculo2 = getVehiculoInfo($conexion, $idVehiculo2);
    $_SESSION['vehiculo2'] = $vehiculo2;
}

if (isset($_POST['submitVehiculo3'])) {
    $idVehiculo3 = $_POST['vehiculo3'];
    $vehiculo3 = getVehiculoInfo($conexion, $idVehiculo3);
    $_SESSION['vehiculo3'] = $vehiculo3;
}

// Botones para eliminar vehículos
if (isset($_POST['eliminarVehiculo1'])) {
    unset($_SESSION['vehiculo1']); 
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit();
}

if (isset($_POST['eliminarVehiculo2'])) {
    unset($_SESSION['vehiculo2']); 
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit();
}

if (isset($_POST['eliminarVehiculo3'])) {
    unset($_SESSION['vehiculo3']); 
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit();
}

// Función para obtener la información del vehículo desde la base de datos
function getVehiculoInfo($conexion, $idVehiculo) {
    $query = "SELECT v.id_vehiculo,v.nombre_modelo, v.precio_modelo, v.caballos_fuerza, v.cantidad_puertas, m.nombre_marca, a.anio, c.nombre_tipo_combustible, p.nombre_pais, t.nombre_transmision, tv.nombre_tipo_vehiculo, f.ruta_foto 
              FROM vehiculo v
              LEFT JOIN fotos_vehiculo f ON v.id_vehiculo = f.id_vehiculo
              LEFT JOIN marca m ON v.id_marca = m.id_marca
              LEFT JOIN anio a ON v.id_anio = a.id_anio
              LEFT JOIN tipo_combustible c ON v.id_tipo_combustible = c.id_tipo_combustible
              LEFT JOIN pais p ON v.id_pais = p.id_pais
              LEFT JOIN transmision t ON v.id_transmision = t.id_transmision
              LEFT JOIN tipo_vehiculo tv ON v.id_tipo_vehiculo = tv.id_tipo_vehiculo
              WHERE v.id_vehiculo = $idVehiculo";
    $result = mysqli_query($conexion, $query);
    return mysqli_fetch_assoc($result);
}

// Función para obtener los modelos de vehículos
function obtenerOpcionesVehiculos($conexion) {
    $query = "SELECT id_vehiculo, nombre_modelo FROM vehiculo";
    $result = mysqli_query($conexion, $query);
    
    $opciones = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $opciones[] = $row;
    }
    return $opciones;
}

$opcionesVehiculos = obtenerOpcionesVehiculos($conexion);
// Incluye el navbar correspondiente según el tipo de usuario
if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
    include '../../admin/navbaradmin.php';
} else {
    include '../../components/navbaruser.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparador de Vehículos - RenzoMotors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6e6e6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main{
            flex: 1;
        }
        .container-banner{
            flex: 1;
        }

        h1 {
            font-weight: bold;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        .img-thumbnail {
            border-radius: 15px;
        }

        .list-group-item {
            background-color: #f8f9fa;
            border: none;
            padding: 8px 15px;
        }

        .list-group-item:not(:last-child) {
            border-bottom: 1px solid #dee2e6;
        }

        .btn-outline-primary {
            border: 2px dashed #007bff;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }

        .banner {
            position: relative;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                            url('../../src/images/vs-banner.jpg'); 
            background-size: cover;
            background-position: center 60%;
            height: 25vh; 
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            z-index: 1;
            text-align: center;
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        }

        .banner h1 {
            font-size: 2rem; 
            margin: 0;
        }

        .banner h2 {
            font-size: 1rem; 
            font-weight: 300;
            margin: 0;
        }

        .modal-title {
            font-weight: bold;
        }

        .form-select {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="mt-5 pt-5">
<main>
    <div class="container banner">
        <h1 class="text-white">Comparador de autos RenzoMotors</h1>
        <h2>¿No estas seguro de que auto elegir? Aquí podrás comparar los precios y especificaciones de nuestros modelos.</h2>
    </div>
    <div class="container mb-5">
        <div class="row text-center mt-3 g-4">
            <div class="col-md-4">
                <div class="card border-warning text-center" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalVehiculo1">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <?php if ($vehiculo1): ?>
                            <?php $ruta_foto = '../../admin/mantenedores/vehiculo/' . $vehiculo1['ruta_foto']; ?>
                            <img src="<?= $ruta_foto ?>" class="img-fluid img-thumbnail mb-3" alt="Foto del vehículo" style="max-height: 150px; object-fit: cover;">
                            <p class="text-warning fw-bold mb-3"><?= $vehiculo1['nombre_modelo']; ?></p>
                            <ul class="list-group list-group-flush text-start w-100 mb-3" style="font-size: 14px;">
                                <li class="list-group-item">Marca: <?= $vehiculo1['nombre_marca']; ?></li>
                                <li class="list-group-item">Año: <?= $vehiculo1['anio']; ?></li>
                                <li class="list-group-item">Precio: <?= $vehiculo1['precio_modelo']; ?> $</li>
                                <li class="list-group-item">Caballos de fuerza: <?= $vehiculo1['caballos_fuerza']; ?> HP</li>
                                <li class="list-group-item">Puertas: <?= $vehiculo1['cantidad_puertas']; ?></li>
                                <li class="list-group-item">Transmisión: <?= $vehiculo1['nombre_transmision']; ?></li>
                                <li class="list-group-item">Combustible: <?= $vehiculo1['nombre_tipo_combustible']; ?></li>
                                <li class="list-group-item">Tipo de Vehículo: <?= $vehiculo1['nombre_tipo_vehiculo']; ?></li>
                                <li class="list-group-item">País de fabricación: <?= $vehiculo1['nombre_pais']; ?></li>
                            </ul>
                            <form method="POST" action="" class="w-100">
                                <a href="../vehiculo.php?id=<?php echo $vehiculo1['id_vehiculo']; ?>" class="btn btn-warning mb-2 w-100">
                                    Ver Vehículo
                                </a>
                                    <button type="submit" name="eliminarVehiculo1" class="btn btn-dark w-100">Eliminar</button>
                            </form>
                        <?php else: ?>
                            <img src="../../src/icons/añadir.svg" alt="Añadir vehículo" width="80" class="mb-3">
                            <p class="text-warning fw-bold" style="font-family: 'Roboto', sans-serif; font-size: 18px;">Añadir Vehículo</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-warning text-center" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalVehiculo2">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <?php if ($vehiculo2): ?>
                            <?php $ruta_foto = '../../admin/mantenedores/vehiculo/' . $vehiculo2['ruta_foto']; ?>
                            <img src="<?= $ruta_foto ?>" class="img-fluid img-thumbnail mb-3" alt="Foto del vehículo" style="max-height: 150px; object-fit: cover;">
                            <p class="text-warning fw-bold mb-3"><?= $vehiculo2['nombre_modelo']; ?></p>
                            <ul class="list-group list-group-flush text-start w-100 mb-3" style="font-size: 14px;">
                                <li class="list-group-item">Marca: <?= $vehiculo2['nombre_marca']; ?></li>
                                <li class="list-group-item">Año: <?= $vehiculo2['anio']; ?></li>
                                <li class="list-group-item">Precio: <?= $vehiculo2['precio_modelo']; ?> $</li>
                                <li class="list-group-item">Caballos de fuerza: <?= $vehiculo2['caballos_fuerza']; ?> HP</li>
                                <li class="list-group-item">Puertas: <?= $vehiculo2['cantidad_puertas']; ?></li>
                                <li class="list-group-item">Transmisión: <?= $vehiculo2['nombre_transmision']; ?></li>
                                <li class="list-group-item">Combustible: <?= $vehiculo2['nombre_tipo_combustible']; ?></li>
                                <li class="list-group-item">Tipo de Vehículo: <?= $vehiculo2['nombre_tipo_vehiculo']; ?></li>
                                <li class="list-group-item">País de fabricación: <?= $vehiculo2['nombre_pais']; ?></li>
                            </ul>
                            <form method="POST" action="" class="w-100">
                                <a href="../vehiculo.php?id=<?php echo $vehiculo2['id_vehiculo']; ?>" class="btn btn-warning mb-2 w-100">
                                    Ver Vehículo
                                </a>
                                <button type="submit" name="eliminarVehiculo2" class="btn btn-dark w-100">Eliminar</button>
                            </form>
                        <?php else: ?>
                            <img src="../../src/icons/añadir.svg" alt="Añadir vehículo" width="80" class="mb-3">
                            <p class="text-warning fw-bold" style="font-family: 'Roboto', sans-serif; font-size: 18px;">Añadir Vehículo</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-warning text-center" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalVehiculo3">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <?php if ($vehiculo3): ?>
                            <?php $ruta_foto = '../../admin/mantenedores/vehiculo/' . $vehiculo3['ruta_foto']; ?>
                            <img src="<?= $ruta_foto ?>" class="img-fluid img-thumbnail mb-3" alt="Foto del vehículo" style="max-height: 150px; object-fit: cover;">
                            <p class="text-warning fw-bold mb-3"><?= $vehiculo3['nombre_modelo']; ?></p>
                            <ul class="list-group list-group-flush text-start w-100 mb-3" style="font-size: 14px;">
                                <li class="list-group-item">Marca: <?= $vehiculo3['nombre_marca']; ?></li>
                                <li class="list-group-item">Año: <?= $vehiculo3['anio']; ?></li>
                                <li class="list-group-item">Precio: <?= $vehiculo3['precio_modelo']; ?> $</li>
                                <li class="list-group-item">Caballos de fuerza: <?= $vehiculo3['caballos_fuerza']; ?> HP</li>
                                <li class="list-group-item">Puertas: <?= $vehiculo3['cantidad_puertas']; ?></li>
                                <li class="list-group-item">Transmisión: <?= $vehiculo3['nombre_transmision']; ?></li>
                                <li class="list-group-item">Combustible: <?= $vehiculo3['nombre_tipo_combustible']; ?></li>
                                <li class="list-group-item">Tipo de Vehículo: <?= $vehiculo3['nombre_tipo_vehiculo']; ?></li>
                                <li class="list-group-item">País de fabricación: <?= $vehiculo3['nombre_pais']; ?></li>
                            </ul>
                            <form method="POST" action="" class="w-100">
                                <a href="../vehiculo.php?id=<?php echo $vehiculo3['id_vehiculo']; ?>" class="btn btn-warning mb-2 w-100">
                                    Ver Vehículo
                                </a>
                                <button type="submit" name="eliminarVehiculo3" class="btn btn-dark w-100">Eliminar</button>
                            </form>
                        <?php else: ?>
                            <img src="../../src/icons/añadir.svg" alt="Añadir vehículo" width="80" class="mb-3">
                            <p class="text-warning fw-bold" style="font-family: 'Roboto', sans-serif; font-size: 18px;">Añadir Vehículo</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


        </div>
    </div>

<!-- Modal para Vehículo 1 -->
<div class="modal fade" id="modalVehiculo1" tabindex="-1" aria-labelledby="modalVehiculo1Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVehiculo1Label">Seleccione un vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-vehiculo" method="POST" action="">
                    <select name="vehiculo1" class="form-select">
                        <option value="">Seleccione un vehículo</option>
                        <?php foreach ($opcionesVehiculos as $vehiculo): ?>
                            <option value="<?= $vehiculo['id_vehiculo']; ?>"><?= $vehiculo['nombre_modelo']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Contenedor para el mensaje de error -->
                    <div class="mensaje-error text-danger mt-2" style="display: none;"></div>
                    <button type="submit" name="submitVehiculo1" class="btn btn-warning mt-3 w-100">Seleccionar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Vehículo 2 -->
<div class="modal fade" id="modalVehiculo2" tabindex="-1" aria-labelledby="modalVehiculo2Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVehiculo2Label">Seleccione un vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-vehiculo" method="POST" action="">
                    <select name="vehiculo2" class="form-select">
                        <option value="">Seleccione un vehículo</option>
                        <?php foreach ($opcionesVehiculos as $vehiculo): ?>
                            <option value="<?= $vehiculo['id_vehiculo']; ?>"><?= $vehiculo['nombre_modelo']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Contenedor para el mensaje de error -->
                    <div class="mensaje-error text-danger mt-2" style="display: none;"></div>
                    <button type="submit" name="submitVehiculo2" class="btn btn-warning mt-3 w-100">Seleccionar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Vehículo 3 -->
<div class="modal fade" id="modalVehiculo3" tabindex="-1" aria-labelledby="modalVehiculo3Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVehiculo3Label">Seleccione un vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-vehiculo" method="POST" action="">
                    <select name="vehiculo3" class="form-select">
                        <option value="">Seleccione un vehículo</option>
                        <?php foreach ($opcionesVehiculos as $vehiculo): ?>
                            <option value="<?= $vehiculo['id_vehiculo']; ?>"><?= $vehiculo['nombre_modelo']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Contenedor para el mensaje de error -->
                    <div class="mensaje-error text-danger mt-2" style="display: none;"></div>
                    <button type="submit" name="submitVehiculo3" class="btn btn-warning mt-3 w-100">Seleccionar</button>
                </form>
            </div>
        </div>
    </div>
</div>
</main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php
    include("../../components/footer.php")
    ?>
</body>
<script>
    // Seleccionamos todos los formularios con la clase 'form-vehiculo'
    const formularios = document.querySelectorAll('.form-vehiculo');

    formularios.forEach((form) => {
        form.addEventListener('submit', function(event) {
            const select = form.querySelector('select'); 
            const mensajeError = form.querySelector('.mensaje-error'); 

      
            if (!select.value) {
                event.preventDefault(); 
                mensajeError.textContent = 'Por favor, seleccione un vehículo antes de continuar.';
                mensajeError.style.display = 'block'; 
            } else {
                mensajeError.style.display = 'none'; 
            }
        });
    });
</script>
</html>
