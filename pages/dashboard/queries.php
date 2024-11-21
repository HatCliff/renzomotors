<?php 

require_once(__DIR__ . "/../config/conexion.php");
function ContadorVentaAccesorios(){
    $query = "SELECT COUNT(*) FROM `registro_accesorio`;";
    return mysqli_query($conn,$query);
}
function ContadorVentaTotalAccesorios(){
    $query = "SELECT SUM(valor_compra) FROM `registro_accesorio`; ";
    return mysqli_query($conn,$query);
}

?>