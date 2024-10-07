<?php 
include '../conexion.php'; 

$id_tipo_vehiculo = $_GET['id_tipo_vehiculo'];

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    //eliminar elemento del mantenedor
    $query = "DELETE FROM tipo_vehiculo WHERE id_tipo_vehiculo = $id_tipo_vehiculo";
    $resultado = mysqli_query($conexion, $query);

    echo "<script>alert('Tipo de Vehículo eliminado con éxito'); window.location='mantenedor_tipo_vehiculos.php';</script>";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        echo "<script>alert('No se puede eliminar el Tipo de Vehículo porque está asociado a un vehículo, elimine el vehículo y vuelva a intentar.'); window.location='mantenedor_tipo_vehiculos.php';</script>";
    } else {
    
        echo "<script>alert('Ocurrió un error al intentar eliminar el Tipo de Vehículo.'); window.location='mantenedor_tipo_vehiculos.php';</script>";
    }
}
?>
