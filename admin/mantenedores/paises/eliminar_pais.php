
<?php 
include '../../../config/conexion.php';


$id = $_GET['id'];

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    //eliminar elemento del mantendor
    $query = "DELETE FROM paises WHERE id_pais = $id";
    $result = mysqli_query($conexion, $query);

    echo "<script>alert('Pais eliminado con éxito'); window.location='mantenedor_paises.php';</script>";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        echo "<script>alert('No se puede eliminar el Pais del Vehículo porque está asociado a un vehículo, elimine el vehículo y vuelva a intentar.'); window.location='mantenedor_paises.php';</script>";
    } else {
    
        echo "<script>alert('Ocurrió un error al intentar eliminar el Pais del Vehículo.'); window.location='mantenedor_paises.php';</script>";
    }
}
?>
