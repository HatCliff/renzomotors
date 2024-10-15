¿
<?php 
include '../conexion.php'; 

$id = $_GET['id'];

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    //eliminar elemento del mantenedor
    $query = "DELETE FROM sucursal WHERE id_sucursal = $id";
    $resultado = mysqli_query($conexion, $query);

    echo "<script>alert('Sucursal eliminada con éxito'); window.location='mantenedor_sucursales.php';</script>";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        echo "<script>alert('No se puede eliminar la Sucursal porque está asociado a un servicio, elimine el servicio y vuelva a intentar.'); window.location='mantenedor_sucursales.php';</script>";
    } else {
    
        echo "<script>alert('Ocurrió un error al intentar eliminar la Sucursalmantenedor_sucursales.'); window.location='mantenedor_sucursales.php';</script>";
    }
}
?>
