<?php

include '../../../config/conexion.php';


$id = $_GET['id_promocion'];
$icono_anterior_tabla = "SELECT icono_promocion FROM promocion_especial WHERE id_promocion = $id";
$resultado_icono = mysqli_query($conexion, $icono_anterior_tabla);
$columna_icono = mysqli_fetch_assoc($resultado_icono);


try {

    if ($columna_icono) {
        $icono_ruta = "icono_promo/" . $columna_icono['icono_promocion'];
    
        // Verificar si el archivo del icono existe y eliminarlos
        if (file_exists($icono_ruta)) {
            if (unlink($icono_ruta)) {
                
            } else {
                echo "<script>alert('Error al intentar eliminar el icono'); window.location='mantenedor_promociones.php';</script>";
            }
        }
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    //eliminar elemento del mantendor
    $query = "DELETE FROM promocion_especial WHERE id_promocion = $id";
    $result = mysqli_query($conexion, $query);

    echo "<script>alert('Promocion eliminada con éxito'); window.location='mantenedor_promociones.php';</script>";
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        echo "<script>alert('No se puede eliminar la Promocion de Vehículo porque está asociado a un vehículo, elimine el vehículo y vuelva a intentar.'); window.location='mantenedor_promociones.php';</script>";
    } else {

        // echo "<script>alert('Ocurrió un error al intentar eliminar el Tipo de Vehículo.'); window.location='mantenedor_promociones.php';</script>";
    }
}
?>