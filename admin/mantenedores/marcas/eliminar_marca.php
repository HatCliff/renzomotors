<?php
include '../../../config/conexion.php';


$id = $_GET['id_marca'];

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
     //eliminar elemento del mantendor
    $query = "DELETE FROM marcas WHERE id_marca = $id";
    $result = mysqli_query($conexion, $query);

    echo "<script>alert('Marca eliminada con éxito'); window.location='mantenedor_marcas.php';</script>";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        echo "<script>alert('No se puede eliminar la Marca de Vehículo porque está asociado a un vehículo, elimine el vehículo y vuelva a intentar.'); window.location='mantenedor_marcas.php';</script>";
    } else {
    
        echo "<script>alert('Ocurrió un error al intentar eliminar el Tipo de Vehículo.'); window.location='mantenedor_marcas.php';</script>";
    }
}
?>
