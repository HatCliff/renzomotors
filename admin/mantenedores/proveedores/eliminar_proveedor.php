
<?php 
include '../../../config/conexion.php';

$id_proveedor = $_GET['id'];

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    //eliminar del mantendor

    $query_imagen = "SELECT imagen_proveedor FROM proveedor WHERE id_proveedor = $id_proveedor";
    $resultado_imagen = mysqli_query($conexion, $query_imagen);
    $proveedor = mysqli_fetch_assoc($resultado_imagen);
    $imagen_proveedor = $proveedor['imagen_proveedor'];

    $query = "DELETE FROM proveedor WHERE id_proveedor = $id_proveedor";
    $resultado = mysqli_query($conexion, $query);

    echo "<script>alert('Proveedor eliminado con éxito'); window.location='mantenedor_proveedores.php';</script>";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        echo "<script>alert('No se puede eliminar el Proveedor porque está asociado a un seguro, elimine el seguro y vuelva a intentar.'); window.location='mantenedor_proveedores.php';</script>";
    } else {
    
        echo "<script>alert('Ocurrió un error al intentar eliminar el Proveedor.'); window.location='mantenedor_proveedores.php';</script>";
    }
}
?>
