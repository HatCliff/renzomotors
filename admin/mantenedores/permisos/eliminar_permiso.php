
<?php 
include '../../../config/conexion.php';


$id_permiso = $_GET['id_permiso'];

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    //eliminar elemento del mantenedor
    $query = "DELETE FROM permisos WHERE id_permiso = $id_permiso";
    $resultado = mysqli_query($conexion, $query);

    echo "<script>alert('Permiso eliminado con éxito'); window.location='mantenedor_permisos.php';</script>";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        echo "<script>alert('No se puede eliminar el Permiso porque está asociado a un Rol, elimine el Rol y vuelva a intentar.'); window.location='mantenedor_permisos.php';</script>";
    } else {
    
        echo "<script>alert('Ocurrió un error al intentar eliminar el Permiso.'); window.location='mantenedor_permisos.php';</script>";
    }
}
?>
