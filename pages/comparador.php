<?php 

session_start();

if (isset($_POST['reiniciar'])) {
    session_unset(); // Borra todos los datos de la sesión
    session_destroy(); // Destruye la sesión
    session_start(); // Inicia una nueva sesión
}

include '../config/conexion.php';
include '../components/navbaruser.php';

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
    $query = "SELECT v.nombre_modelo, v.precio_modelo, v.caballos_fuerza, v.cantidad_puertas, m.nombre_marca, a.anio, c.nombre_tipo_combustible, p.nombre_pais, t.nombre_transmision, tv.nombre_tipo_vehiculo, f.ruta_foto 
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

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparador de Vehículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="mt-5 pt-5">
<div class="text-center pt-4">
    <h1>Comparador de Vehiculos de RenzoMotors</h1>
</div>
<div class="container">
    <div class="row text-center mt-5">
        <div class="d-flex justify-content-center">
            <form method="POST" action="">
                <button type="submit" name="reiniciar" class="btn btn-dark">Reiniciar Comparación</button>
            </form>
        </div>
        

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <?php if ($vehiculo1): ?>
                        <?php $ruta_foto = '../admin/mantenedores/vehiculo/' . $vehiculo1['ruta_foto']; ?>
                        <img src="<?= $ruta_foto ?>" class="img-fluid img-thumbnail" alt="Foto del vehículo" style="height: 200px; object-fit: cover;">
                        <p><strong><?= $vehiculo1['nombre_modelo']; ?></strong></p>
                        <ul class="list-group">
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
                        <form method="POST" action="">
                            <button type="submit" name="eliminarVehiculo1" class="btn btn-dark mt-2">Eliminar</button>
                        </form>
                    <?php else: ?>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalVehiculo1">
                            <img src="../src/icons/añadir.svg" alt="Añadir vehículo" width="80">
                            <p>Añadir vehículo</p>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <?php if ($vehiculo2): ?>
                        <?php $ruta_foto2 = '../admin/mantenedores/vehiculo/' . $vehiculo2['ruta_foto']; ?>
                        <img src="<?= $ruta_foto2 ?>" class="img-fluid img-thumbnail" alt="Foto del vehículo" style="height: 200px; object-fit: cover;">
                        <p><strong><?= $vehiculo2['nombre_modelo']; ?></strong></p>
                        <ul class="list-group">
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
                        <form method="POST" action="">
                            <button type="submit" name="eliminarVehiculo2" class="btn btn-dark mt-2">Eliminar</button>
                        </form>
                    <?php else: ?>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalVehiculo2">
                            <img src="../src/icons/añadir.svg" alt="Añadir vehículo" width="80">
                            <p>Añadir vehículo</p>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <?php if ($vehiculo3): ?>
                        <?php $ruta_foto3 = '../admin/mantenedores/vehiculo/' . $vehiculo3['ruta_foto']; ?>
                        <img src="<?= $ruta_foto3 ?>" class="img-fluid img-thumbnail" alt="Foto del vehículo" style="height: 200px; object-fit: cover;">
                        <p><strong><?= $vehiculo3['nombre_modelo']; ?></strong></p>
                        <ul class="list-group">
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
                        <form method="POST" action="">
                            <button type="submit" name="eliminarVehiculo3" class="btn btn-dark mt-2">Eliminar</button>
                        </form>
                    <?php else: ?>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalVehiculo3">
                            <img src="../src/icons/añadir.svg" alt="Añadir vehículo" width="80">
                            <p>Añadir vehículo</p>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modalVehiculo1" tabindex="-1" aria-labelledby="modalVehiculo1Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVehiculo1Label">Seleccione un vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <select name="vehiculo1" class="form-select">
                        <option value="">Seleccione un vehículo</option>
                        <?php foreach ($opcionesVehiculos as $vehiculo): ?>
                            <option value="<?= $vehiculo['id_vehiculo']; ?>"><?= $vehiculo['nombre_modelo']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="submitVehiculo1" class="btn btn-primary mt-3">Seleccionar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalVehiculo2" tabindex="-1" aria-labelledby="modalVehiculo2Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVehiculo2Label">Seleccione un vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <select name="vehiculo2" class="form-select">
                        <option value="">Seleccione un vehículo</option>
                        <?php foreach ($opcionesVehiculos as $vehiculo): ?>
                            <option value="<?= $vehiculo['id_vehiculo']; ?>"><?= $vehiculo['nombre_modelo']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="submitVehiculo2" class="btn btn-primary mt-3">Seleccionar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalVehiculo3" tabindex="-1" aria-labelledby="modalVehiculo3Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVehiculo3Label">Seleccione un vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <select name="vehiculo3" class="form-select">
                        <option value="">Seleccione un vehículo</option>
                        <?php foreach ($opcionesVehiculos as $vehiculo): ?>
                            <option value="<?= $vehiculo['id_vehiculo']; ?>"><?= $vehiculo['nombre_modelo']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="submitVehiculo3" class="btn btn-primary mt-3">Seleccionar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
