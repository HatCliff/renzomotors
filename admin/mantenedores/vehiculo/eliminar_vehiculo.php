<?php 
include '../../../config/conexion.php';

$id_vehiculo = $_GET['id'];

//  obtener las fotos asociadas al vehículo para eliminarlas de la carpeta 
$query_fotos = "SELECT ruta_foto FROM fotos_vehiculo WHERE id_vehiculo = $id_vehiculo";
$result_fotos = mysqli_query($conexion, $query_fotos);

if ($result_fotos) {
    while ($foto = mysqli_fetch_assoc($result_fotos)) {
        $ruta_foto = $foto['ruta_foto'];
        // Eliminar la foto del servidor
        if (file_exists($ruta_foto)) {
            unlink($ruta_foto); // Elimina el archivo
        }
    }
}

//  obtener el documento del vehículo para eliminarlo
$query_docs = "SELECT documento_tecnico FROM vehiculo WHERE id_vehiculo = $id_vehiculo";
$result_docs = mysqli_query($conexion, $query_docs);

if ($result_docs) {
    while ($doc = mysqli_fetch_assoc($result_docs)) {
        $ruta_doc = "doc_tecnicos/" . $doc['documento_tecnico'];
        // Eliminar la foto del servidor
        if (file_exists($ruta_doc)) {
            unlink($ruta_doc); // Elimina el archivo
        }
    }
}

//eliminar las opiniones 
$query_opinion = "DELETE FROM opinion_vehiculo WHERE id_vehiculo = $id_vehiculo";
mysqli_query($conexion, $query_opinion);

// eliminar las fotos de la base de datos
$query_eliminar_fotos = "DELETE FROM fotos_vehiculo WHERE id_vehiculo = $id_vehiculo";
mysqli_query($conexion, $query_eliminar_fotos);

// eliminar los colores asociados al vehículo
$query_eliminar_colores = "DELETE FROM color_vehiculo WHERE id_vehiculo = $id_vehiculo";
mysqli_query($conexion, $query_eliminar_colores);

// eliminar las sucursales asociadas al vehículo
$query_eliminar_sucursales = "DELETE FROM vehiculo_sucursal WHERE id_vehiculo = $id_vehiculo";
mysqli_query($conexion, $query_eliminar_sucursales);

// eliminar las promociones asociadas al vehículo
$query_eliminar_promociones = "DELETE FROM promocion_vehiculo WHERE id_vehiculo = $id_vehiculo";
mysqli_query($conexion, $query_eliminar_promociones);

// eliminar el vehículo
$query_eliminar_vehiculo = "DELETE FROM vehiculo WHERE id_vehiculo = $id_vehiculo";
$resultado = mysqli_query($conexion, $query_eliminar_vehiculo);

if ($resultado) {
    echo "<script>alert('Vehículo y sus datos asociados eliminados con éxito'); window.location='mantenedor_vehiculos.php';</script>";
} else {
    echo "Error: " . mysqli_error($conexion);
}
?>
