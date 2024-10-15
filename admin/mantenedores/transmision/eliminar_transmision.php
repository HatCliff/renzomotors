
<?php 
include '../conexion.php'; 

$id_transmision = $_GET['id_transmision'];

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    //eliminar del mantenedor
    $query = "DELETE FROM transmision WHERE id_transmision = $id_transmision";
    $resultado = mysqli_query($conexion, $query);

    echo "<script>alert('Transmisión eliminada con éxito'); window.location='mantenedor_transmisiones.php';</script>";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        echo "<script>alert('No se puede eliminar el Tipo de Transmision porque está asociado a un vehículo, elimine el vehículo y vuelva a intentar.'); window.location='mantenedor_transmisiones.php';</script>";
    } else {
    
        echo "<script>alert('No se puede eliminar el Tipo de Transmision .'); window.location='mantenedor_transmisiones.php';</script>";
    }
}
?>