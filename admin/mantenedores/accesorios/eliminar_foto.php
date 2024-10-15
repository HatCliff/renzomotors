<?php 
include '../conexion.php'; 

$id_foto= $_GET['id_foto'];
$sku= $_GET['sku_accesorio'];
$ruta_foto=$_GET['ruta_foto'];
// Eliminar las fotos de la base de datos
$query_eliminar_fotos = "DELETE FROM fotos_accesorio WHERE sku_accesorio = '$sku' AND id_foto_accesorio='$id_foto' ";
mysqli_query($conexion, $query_eliminar_fotos);
unlink($ruta_foto); // Elimina el archivo
echo "<script>alert('foto eliminado con éxito'); window.location='editar_accesorio.php?sku=$sku';</script>";

?>

