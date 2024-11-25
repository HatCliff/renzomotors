<?php 
require_once(__DIR__ . "/../../config/conexion.php");

function ContadorVentaAccesorios(){
    global $conn;
    $query = "SELECT COUNT(*) as `count`  FROM `registro_accesorio`;";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count']; // Devuelve el resultado
    } else {
        return "Error: " . mysqli_error($conn); // Maneja errores
    }
    //return mysqli_query($conn,$query);
}
function ContadorVentaTotalAccesorios(){
    global $conn;
    $query = "SELECT SUM(valor_compra) as `total` FROM `registro_accesorio`; ";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total']; // Devuelve el resultado
    } else {
        return "Error: " . mysqli_error($conn); // Maneja errores
    }
}

function ContadorReservasConcretadas(){
    global $conn; 
    $query = "
    SELECT 
        COUNT(CASE WHEN compra_concretada IS NOT NULL THEN 1 END) AS reservas_concretadas,
        COUNT(CASE WHEN compra_concretada IS NULL THEN 1 END) AS reservas_no_concretadas
    FROM registro_reserva
    ";

    $result = mysqli_query($conn,$query);
    if($result){
        $row = mysqli_fetch_assoc($result);
        $total_res = mysqli_num_rows($result);
        echo $row['reservas_concretadas']/$total_res;
        echo $row['reservas_no_concretadas'];
        return $row;
    }else{
        return "Error:" .mysqli_error($conn);
    }
}

?>