
<?php 
include '../../../config/conexion.php';


$id_color = $_GET['id_color'];

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    //eliminar elemento del mantendor
    $query = "DELETE FROM color WHERE id_color = $id_color";
    $resultado = mysqli_query($conexion, $query);

    echo "<script>alert('Color eliminado con éxito'); window.location='mantenedor_colores.php';</script>";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        echo "<script>alert('No se puede eliminar el Color de Vehículo porque está asociado a un vehículo, elimine el vehículo y vuelva a intentar.'); window.location='mantenedor_colores.php';</script>";
    } else {
    
        echo "<script>alert('Ocurrió un error al intentar eliminar el Color de Vehículo.'); window.location='mantenedor_colores.php';</script>";
    }
}
?>
