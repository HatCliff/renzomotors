<?php 
include '../conexion.php'; 

$id_foto= $_GET['id_foto'];
$id_vehiculo= $_GET['id_vehiculo'];
$ruta_foto=$_GET['ruta_foto'];
// Eliminar las fotos de la base de datos
$query_eliminar_fotos = "DELETE FROM fotos_vehiculo WHERE id_vehiculo = '$id_vehiculo' AND id_foto_vehiculo='$id_foto' ";
mysqli_query($conexion, $query_eliminar_fotos);
unlink($ruta_foto); // Elimina el archivo
echo "<script>alert('foto eliminado con éxito'); window.location='editar_vehiculo.php?id=$id_vehiculo';</script>";

?>

