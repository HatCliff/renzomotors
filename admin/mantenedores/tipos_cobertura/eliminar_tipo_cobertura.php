
<?php 
include '../conexion.php'; 

$id = $_GET['id'];

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    //eliminar el elemento del mantenedor
    $query = "DELETE FROM cobertura WHERE id_cobertura = $id";
    $resultado = mysqli_query($conexion, $query);

    echo "<script>alert('Tipo de cobertura eliminado con éxito'); window.location='mantenedor_tipo_coberturas.php';</script>";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        echo "<script>alert('No se puede eliminar el Tipo de Cobertura porque está asociado a un seguro, elimine el seguro y vuelva a intentar.'); window.location='mantenedor_tipo_coberturas.php';</script>";
    } else {
    
        echo "<script>alert('Ocurrió un error al intentar eliminar el Tipo de Cobertura.'); window.location='mantenedor_tipo_coberturas.php';</script>";
    }
}
?>
