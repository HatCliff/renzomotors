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
function HistoricoVentasPorMes($local){
    global $conexion;

    // Escapar el valor de $local para prevenir inyecciones SQL
    $local = mysqli_real_escape_string($conexion, $local);

    // Si se proporciona un 'local', ajustamos la consulta, sino la consulta será global.
    $query = "SELECT MONTH(fecha_compra_a) as mes, COUNT(*) as ventas FROM registro_accesorio";
    
    if ($local != null) {
        // Si el parámetro 'local' no es null, filtramos por la sucursal.
        $query .= " WHERE sucursal_compra = '$local'";
    }else{
        //Load all
        $query .= " WHERE sucursal_compra IS NOT NULL";
    }

    // Agrupamos los resultados por mes
    $query .= " GROUP BY MONTH(fecha_compra_a);";
    
    $result = mysqli_query($conexion, $query);
    if ($result) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        // Retorna los datos como JSON
        echo json_encode($data);
    } else {
        // Si hay un error, retornamos un mensaje de error
        echo json_encode(array("error" => "Error: " . mysqli_error($conexion)));
    }
}


?>