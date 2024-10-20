<?php
<<<<<<< HEAD
include '../conexion.php';
=======
include '../../../config/conexion.php';
>>>>>>> fmunozi

$id = $_GET['id_marca'];
$logo_anterior_tabla = "SELECT logo_marca FROM marca WHERE id_marca = $id";
$resultado_logo = mysqli_query($conexion, $logo_anterior_tabla);
$columna_logo = mysqli_fetch_assoc($resultado_logo);


try {

    if ($columna_logo) {
        $logo_ruta = "logos/" . $columna_logo['logo_marca'];
    
        // Verificar si el archivo del logo existe y eliminarlos
        if (file_exists($logo_ruta)) {
            if (unlink($logo_ruta)) {
                
            } else {
                echo "<script>alert('Error al intentar eliminar el logo'); window.location='mantenedor_marcas.php';</script>";
            }
        }
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    //eliminar elemento del mantendor
    $query = "DELETE FROM marca WHERE id_marca = $id";
    $result = mysqli_query($conexion, $query);

    echo "<script>alert('Marca eliminada con éxito'); window.location='mantenedor_marcas.php';</script>";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        echo "<script>alert('No se puede eliminar la Marca de Vehículo porque está asociado a un vehículo, elimine el vehículo y vuelva a intentar.'); window.location='mantenedor_marcas.php';</script>";
    } else {

        // echo "<script>alert('Ocurrió un error al intentar eliminar el Tipo de Vehículo.'); window.location='mantenedor_marcas.php';</script>";
    }
}
?>