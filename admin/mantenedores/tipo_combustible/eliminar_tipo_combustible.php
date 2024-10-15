
<?php 
include '../../../config/conexion.php';

$id_tipo_combustible = $_GET['id_tipo_combustible'];

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    //eliminar elemento del mantenedor
    $query = "DELETE FROM tipo_combustible WHERE id_tipo_combustible = $id_tipo_combustible";
    $resultado = mysqli_query($conexion, $query);

    echo "<script>alert('Tipo de Vehiculo eliminado con éxito'); window.location='mantenedor_tipo_combustibles.php';</script>";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        echo "<script>alert('No se puede eliminar el Tipo de Combustible porque está asociado a un vehículo, elimine el vehículo y vuelva a intentar.'); window.location='mantenedor_tipo_combustibles.php';</script>";
    } else {
    
        echo "<script>alert('Ocurrió un error al intentar eliminar el Tipo de Combustible.'); window.location='mantenedor_tipo_combustibles.php';</script>";
    }
}
?>
