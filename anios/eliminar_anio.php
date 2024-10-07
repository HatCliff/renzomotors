
<?php 
include '../conexion.php'; 

$id_anio = $_GET['id_anio'];

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    //eliminar elemento del mantendor
    $query = "DELETE FROM anios WHERE id_anio = $id_anio";
    $resultado = mysqli_query($conexion, $query);

    echo "<script>alert('Año eliminado con éxito'); window.location='mantenedor_anios.php';</script>";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        echo "<script>alert('No se puede eliminar el Año porque está asociado a un vehículo, elimine el vehículo y vuelva a intentar.'); window.location='mantenedor_anios.php';</script>";
    } else {
    
        echo "<script>alert('Ocurrió un error al intentar eliminar el Año.'); window.location='mantenedor_anios.php';</script>";
    }
}
?>
