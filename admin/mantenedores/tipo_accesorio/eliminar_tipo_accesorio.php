

<?php 
include '../../../config/conexion.php';

$id_tipo_accesorio = $_GET['id_tipo_accesorio'];

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    //eliminar elemento del mantenedor
    $query = "DELETE FROM tipo_accesorio WHERE id_tipo_accesorio='$id_tipo_accesorio'";
    $resultado = mysqli_query($conexion, $query);

echo "<script>alert('Tipo de accesorio eliminado con éxito'); window.location='mantenedor_tipo_accesorios.php';</script>";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        echo "<script>alert('No se puede eliminar el tipo de accesorio porque está asociado a un accesorio.'); window.location='mantenedor_tipo_accesorios.php';</script>";
    } else {
    
        echo "<script>alert('Ocurrió un error al intentar eliminar el Tipo de accesorio.'); window.location='mantenedor_tipo_accesorios.php';</script>";
    }
}
?>
