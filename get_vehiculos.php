<?php
include("config/conexion.php"); // Asegúrate de incluir correctamente tu archivo de conexión

header('Content-Type: application/json'); // Configuración para devolver JSON

$action = $_GET['action'] ?? '';

if ($action === 'getEstados') {
    // Opciones estáticas para el estado del vehículo
    $estados = [
        ['value' => 'usado', 'label' => 'Usado'],
        ['value' => 'nuevo', 'label' => 'Nuevo']
    ];
    echo json_encode($estados);
} elseif ($action === 'getTiposVehiculo') {
    $estado = $_GET['estado'] ?? '';
    $marca = $_GET['marca'] ?? '';
    $modelo = $_GET['modelo'] ?? '';

    $query = "SELECT DISTINCT t.id_tipo_vehiculo, t.nombre_tipo_vehiculo 
              FROM vehiculo v
              INNER JOIN tipo_vehiculo t ON v.id_tipo_vehiculo = t.id_tipo_vehiculo
              WHERE 1=1";

    if (!empty($estado)) {
        $query .= " AND v.estado_vehiculo = '$estado'";
    }
    if (!empty($marca)) {
        $query .= " AND v.id_marca = $marca";
    }
    if (!empty($modelo)) {
        $query .= " AND v.id_vehiculo = $modelo";
    }

    $result = mysqli_query($conexion, $query);

    if ($result) {
        $tipos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $tipos[] = $row;
        }
        echo json_encode($tipos);
    } else {
        echo json_encode([]);
    }
} elseif ($action === 'getMarcas') {
    $estado = $_GET['estado'] ?? '';
    $tipo = $_GET['tipo'] ?? '';
    $modelo = $_GET['modelo'] ?? '';

    $query = "SELECT DISTINCT m.id_marca, m.nombre_marca 
              FROM vehiculo v
              INNER JOIN marca m ON v.id_marca = m.id_marca
              WHERE 1=1";

    if (!empty($estado)) {
        $query .= " AND v.estado_vehiculo = '$estado'";
    }
    if (!empty($tipo)) {
        $query .= " AND v.id_tipo_vehiculo = $tipo";
    }
    if (!empty($modelo)) {
        $query .= " AND v.id_vehiculo = $modelo";
    }

    $result = mysqli_query($conexion, $query);

    if ($result) {
        $marcas = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $marcas[] = $row;
        }
        echo json_encode($marcas);
    } else {
        echo json_encode([]);
    }
} elseif ($action === 'getModelos') {
    $estado = $_GET['estado'] ?? '';
    $tipo = $_GET['tipo'] ?? '';
    $marca = $_GET['marca'] ?? '';

    $query = "SELECT id_vehiculo, nombre_modelo 
              FROM vehiculo 
              WHERE 1=1";

    if (!empty($estado)) {
        $query .= " AND estado_vehiculo = '$estado'";
    }
    if (!empty($tipo)) {
        $query .= " AND id_tipo_vehiculo = $tipo";
    }
    if (!empty($marca)) {
        $query .= " AND id_marca = $marca";
    }

    $result = mysqli_query($conexion, $query);

    if ($result) {
        $modelos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $modelos[] = $row;
        }
        echo json_encode($modelos);
    } else {
        echo json_encode([]);
    }
}
?>
