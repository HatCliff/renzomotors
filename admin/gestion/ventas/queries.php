<?php 
require_once(__DIR__ . "/../../config/conexion.php");

function ContadorVentaAccesorios(){
    global $conexion;
    $query = "SELECT COUNT(*) as `count`  FROM `registro_accesorio`;";
    $result = mysqli_query($conexion, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count']; // Devuelve el resultado
    } else {
        return "Error: " . mysqli_error($conexion); // Maneja errores
    }
    //return mysqli_query($conexion,$query);
}
function ContadorVentaTotalAccesorios(){
    global $conexion;
    $query = "SELECT SUM(valor_compra) as `total` FROM `registro_accesorio`; ";
    $result = mysqli_query($conexion, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ? $row['total'] : 0; // Devuelve el resultado o 0 si no hay resultado
    } else {
        return "Error: " . mysqli_error($conexion); // Maneja errores
    }
}

function ContadorReservasConcretadas(){
    global $conexion; 
    $query = "
    SELECT 
        COUNT(CASE WHEN compra_concretada IS NOT NULL THEN 1 END) AS reservas_concretadas,
        COUNT(CASE WHEN compra_concretada IS NULL THEN 1 END) AS reservas_no_concretadas
    FROM registro_reserva
    ";

    $result = mysqli_query($conexion,$query);
    if($result){
        $row = mysqli_fetch_assoc($result);
        //$total_res = $row['reservas_concretadas'] + $row['reservas_no_concretadas'];
        //echo $row['reservas_concretadas']/$total_res;
        //echo $row['reservas_no_concretadas'];
        return $row;
    }else{
        return "Error:" .mysqli_error($conexion);
    }
}
function ContadorSegurosContratados(){
    global $conexion;
    $query = "SELECT COUNT(*) as `count` FROM `usuario_seguro`;";
    $result = mysqli_query($conexion, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count']; // Devuelve el resultado
    } else {
        return "Error: " . mysqli_error($conexion); // Maneja errores
    }
}
function HistoricoVentasPorMes($local) {
    global $conexion;

    // Escapar el valor de $local para prevenir inyecciones SQL
    $local = mysqli_real_escape_string($conexion, $local);

    // Construimos la consulta base con condición opcional
    $query = "SELECT DATE_FORMAT(fecha_compra_a, '%M %Y') AS mes, COUNT(*) AS ventas 
            FROM registro_accesorio";

    // Agregamos el filtro por sucursal si $local no es null
    if ($local !== 'all') {
        $query .= " WHERE sucursal_compra = '$local'";
    }

    // Agregamos GROUP BY y ORDER BY
    $query .= " GROUP BY mes ORDER BY fecha_compra_a ASC";

    // Ejecutamos la consulta
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        // Retornamos los datos como JSON
        echo json_encode($data);
    } else {
        // Retornamos un mensaje de error si ocurre un problema
        echo json_encode(array("error" => "Error: " . mysqli_error($conexion)));
    }
}

?>